<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Doctor;
use App\Models\DoctorAppointments;
use App\Models\Image;
use App\Models\MedicalSpecialty;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
                'name' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
            ],
            [
                'name.required' => 'Vui lòng nhập tên đăng nhập.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            ]
        );
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if($request->email != $user->email){
            return redirect()->back()->with('warning', "Không được thay đổi email");
        }

        
        $oldImage = $user->image;
        $image_id = $oldImage->id ?? null;

        if ($request->hasFile('image')) {
            $user->update([
                'image_id' => null,
            ]);

            $image = $request->file('image');
            $name = time() . '_' . $image->getClientOriginalName();
            $size = $image->getSize();
            $path = $image->storeAs('uploads', $name, 'public');
            $created_by = Auth::id();

            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
                'created_by'=> $created_by
            ]);
            $image_id = $key->id;

            if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
                $user->update([
                    'image_id' => null,
                ]);
                Storage::disk('public')->delete($oldImage->src);
                $oldImage->delete();
            }
        }
        elseif ($request->input('remove_image') == 1 && $oldImage) {
            if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
                Storage::disk('public')->delete($oldImage->src);
                $oldImage->delete();
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'address' => $request->address,
            'image_id' => $image_id,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data);
    
        return back()->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function site()
    {
        $site = Site::firstOrCreate(['id' => 1], [
            'phone' => '',
            'hotline' => '',
            'email' => '',
            'address' => '',
            'link_facebook' => '',
            'link_zalo' => '',
            'link_youtube' => '',
        ]);
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
