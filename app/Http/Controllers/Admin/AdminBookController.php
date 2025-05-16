<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMailCancelBook;
use App\Models\Book;
use App\Models\Doctor;
use App\Models\MedicalSpecialty;
use App\Models\User;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();
        $statusMap = [
            1 => ['name' => 'Chưa xác nhận', 'color' => 'secondary'],
            2 => ['name' => 'Đã xác nhận', 'color' => 'primary'],
            3 => ['name' => 'Đã hủy', 'color' => 'danger'],
            4 => ['name' => 'Đang khám', 'color' => 'warning'],
            5 => ['name' => 'Chờ kết quả', 'color' => 'info'],
            6 => ['name' => 'Đã có kết quả', 'color' => 'success'],
        ];
        $medical_specialties = MedicalSpecialty::orderByDesc('created_date_int')->get();
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        $isAdmin = $user->hasRole('admin');
        if ($isDoctor && !$isAdmin) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $query->where('doctor_id', $doctor->id);
            }
        }

        $query->when($request->doctor_id, fn($q) => $q->where('doctor_id', $request->doctor_id));
        $query->when($request->date_examination, fn($q) => $q->where('date_examination', $request->date_examination));
        $query->when($request->specialty_id, fn($q) => $q->where('specialty_id', $request->specialty_id));
        $query->when($request->status, fn($q) => $q->where('status', $request->status));
        $query->when($request->keyword, function ($q, $keyword) {
            $q->where(function ($sub) use ($keyword) {
                $sub->where('email', 'like', "%$keyword%")
                    ->orWhere('name', 'like', "%$keyword%");
            });
        });

        $selectedDoctor = null;
        if ($request->filled('doctor_id')) {
            $selectedDoctor = Doctor::find($request->doctor_id);
        }

        $books = $query->orderByDesc('created_date_int')->paginate(10)->withQueryString();

        return view('admin.book.list', compact('statusMap', 'books', 'medical_specialties', 'selectedDoctor', 'isAdmin'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Book $book)
    {
        // dd($book->toArray());
        $statusMap = [
            1 => ['name' => 'Chưa xác nhận', 'color' => 'secondary'],
            2 => ['name' => 'Đã xác nhận', 'color' => 'primary'],
            3 => ['name' => 'Đã hủy', 'color' => 'danger'],
            4 => ['name' => 'Đang khám', 'color' => 'warning'],
            5 => ['name' => 'Chờ kết quả', 'color' => 'info'],
            6 => ['name' => 'Đã có kết quả', 'color' => 'success'],
        ];
        return view('admin.book.detail', compact('book', 'statusMap'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'email' => ':attribute không đúng định dạng',
                'max' => ':attribute không được quá :max kí tự'
            ],
            [
                'name' => 'Tên bệnh nhân',
                'email' => 'E-mail',
            ]
        );

        $book->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'birth' => $request->input('birth'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('book.show', $book->id)->with('success', 'Cập nhật thông tin bệnh nhân thành công.');
    }

    public function startExamination(Book $book){
        if($book->status == 1){
            return redirect()->back()->with('error', 'Chưa xác nhận lịch hẹn.');
        }
        if($book->status == 3){
            return redirect()->back()->with('error', 'Lịch hẹn này đã bị hủy.');
        }
        //Chưa xử lý
    }

    public function searchDoctor(Request $request){
        $q = $request->query('q');
        $doctors = Doctor::where('name', 'like', '%' . $q . '%')
            ->limit(10)
            ->get(['id', 'name']);
    
        return response()->json($doctors);
    }

    public function cancelAppointment(Request $request){
        $book_id = $request->input('book_id');
        $email = $request->input('email');
        $reason = $request->input('reason');
        $book = Book::find($book_id);
        if (!$book) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy lịch hẹn.']);
        }

        if($book->status == 3){
            return response()->json(['status' => 'error', 'message' => 'Lịch hẹn này đã được hủy từ trước.']);
        }

        if (in_array($book->status, [4, 5, 6])) {
            return response()->json(['status' => 'error', 'message' => 'Không thể hủy lịch hẹn này.']);
        }

        if(!$email){
            return response()->json(['status' => 'error', 'message' => 'Không có email của bệnh nhân.']);
        }

        //Cập nhật hủy - books
        $book->status = 3;
        $book->save();

        //Cập nhật laij trạng thái lịch hẹn
        if ($book->appointment) {
            $book->appointment->is_appointment = 2;
            $book->appointment->save();
        }

        //Gửi mail
        $hour_examination = $book->appointment?->hour_examination;
        $time_examination = $hour_examination . " ngày " . $book->date_examination;
        $doctor_name = $book->doctor?->name;
        $specialty = $book->specialty?->name;
        $site = Site::first();
        $email_web = $site->email;
        $phone = collect([$site?->phone, $site?->hotline])->filter()->implode(' - ');

        $data = [
            'name' => $book->name,
            'book_code' => $book->book_code,
            'time_examination' => $time_examination,
            'doctor_name' => $doctor_name,
            'specialty' => $specialty,
            'reason' => $reason ? $reason : "Bác sĩ thay đổi lịch làm việc.",
            'email_web' => $email_web,
            'phone' => $phone
        ];
        Mail::to($email)->send(new SendMailCancelBook($data));

        return response()->json(['status' => 'success', 'message' => 'Lịch hẹn đã được hủy.']);
    }
}
