<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Doctor;
use App\Models\DoctorAppointments;
use App\Models\MedicalSpecialty;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $todayInt = Carbon::today()->startOfDay()->timestamp;
        $startOfMonthInt = Carbon::now()->startOfMonth()->startOfDay()->timestamp;
        $endOfMonthInt = Carbon::now()->endOfMonth()->startOfDay()->timestamp;
        $thisMonth = Carbon::now()->month;

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        $isAdmin = $user->hasRole('admin');
        if($isDoctor && !$isAdmin){
            $doctorId = $user->doctor->id;
        }

        $medicalSpecialtyCount = number_format(MedicalSpecialty::count(), 0, ',', '.');
        $doctorCount = number_format(Doctor::count(), 0, ',', '.');

        //Lịch khám
        $appointmentTodayQuery = DoctorAppointments::query();
        $appointmentMonthQuery = DoctorAppointments::query();

        if ($isDoctor && !$isAdmin && $doctorId) {
            $appointmentTodayQuery->where('doctor_id', $doctorId);
            $appointmentMonthQuery->where('doctor_id', $doctorId);
        }

        $appointmentsToday = $appointmentTodayQuery->where('day_examination', $todayInt)->count();
        $appointmentsThisMonth = $appointmentMonthQuery->whereBetween('day_examination', [$startOfMonthInt, $endOfMonthInt])->count();
        
        $appointmentsTodayFormatted = number_format($appointmentsToday, 0, ',', '.');
        $appointmentsThisMonthFormatted = number_format($appointmentsThisMonth, 0, ',', '.');

        //Lịch hẹn
        $booksTodayQuery = Book::query();
        $booksMonthQuery = Book::query();

        if ($isDoctor && !$isAdmin && $doctorId) {
            $booksTodayQuery->where('doctor_id', $doctorId);
            $booksMonthQuery->where('doctor_id', $doctorId);
        }

        $booksToday = $booksTodayQuery->where('date_examination_int', $todayInt)->count();
        $booksThisMonth = $booksMonthQuery->whereBetween('date_examination_int', [$startOfMonthInt, $endOfMonthInt])->count();

        $booksTodayFormatted = number_format($booksToday, 0, ',', '.');
        $booksThisMonthFormatted = number_format($booksThisMonth, 0, ',', '.');

        //Lấy lịch hẹn trong ngày & tháng
        $type = $request->query('type');
        $baseBooksQuery = Book::query();
        $baseStatusQuery = Book::query();
        if ($isDoctor && !$isAdmin && $doctorId) {
            $baseBooksQuery->where('doctor_id', $doctorId);
        }

        if ($type == 'month') {
            $baseBooksQuery->whereBetween('date_examination_int', [$startOfMonthInt, $endOfMonthInt]);
            $baseStatusQuery->whereBetween('date_examination_int', [$startOfMonthInt, $endOfMonthInt]);
        } else {
            $baseBooksQuery->where('date_examination_int', $todayInt);
            $baseStatusQuery->where('date_examination_int', $todayInt);
        }

        $listBooks = $baseBooksQuery->orderByDesc('created_date_int')->paginate(10)->withQueryString();

        $statusCount = $baseStatusQuery->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        $statusMap = [
            1 => ['name' => 'Chưa xác nhận', 'color' => 'secondary'],
            2 => ['name' => 'Đã xác nhận', 'color' => 'primary'],
            3 => ['name' => 'Đã hủy', 'color' => 'danger'],
            4 => ['name' => 'Đang khám', 'color' => 'warning'],
            5 => ['name' => 'Chờ kết quả', 'color' => 'info'],
            6 => ['name' => 'Đã có kết quả', 'color' => 'success'],
        ];

        return view('admin.dashboard', compact('thisMonth', 'medicalSpecialtyCount', 'doctorCount', 'appointmentsTodayFormatted', 'appointmentsThisMonthFormatted', 'booksTodayFormatted', 'booksThisMonthFormatted', 'listBooks', 'statusMap', 'statusCount'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profile_update(Request $request){
        $request->validate(
            [
                'username' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
            ],
            [
                'username.required' => 'Vui lòng nhập tên đăng nhập.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $data = [
            'name' => $request->username,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data);
    
        return back()->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function site()
    {
        $site = Site::findOrFail(1);
        return view('admin.site', compact('site'));
    }

    public function site_update(Request $request){
        $phone = $request->phone;
        $hotline = $request->hotline;
        $email = $request->email;
        $address = $request->address;
        $link_facebook = $request->link_facebook;
        $link_zalo = $request->link_zalo;
        $link_youtube = $request->link_youtube;
        Site::where('id', 1)->update([
            'phone' => $phone,
            'hotline' => $hotline,
            'email' => $email,
            'address' => $address,
            'link_facebook' => $link_facebook,
            'link_zalo' => $link_zalo,
            'link_youtube' => $link_youtube,
        ]);        
    
        return back()->with('success', 'Cập nhật thông tin thành công.');
    }
}
