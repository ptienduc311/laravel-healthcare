<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMailCancelBook;
use App\Mail\SendMailResultExamination;
use App\Models\Book;
use App\Models\Doctor;
use App\Models\ExaminationResult;
use App\Models\MedicalSpecialty;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

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
        if ($isDoctor) {
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        if($isDoctor && $user->doctor->id != $book->doctor_id){
            return abort(404);
        }

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
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'birth' => $request->input('birth'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('book.show', $book->id)->with('success', 'Cập nhật thông tin bệnh nhân thành công.');
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

    //Khám bệnh
    public function startExamination(Book $book){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        if($isDoctor && $user->doctor->id != $book->doctor_id){
            return abort(404);
        }
        
        if($book->status == 1){
            return redirect('/admin/book')->with('error', 'Chưa xác nhận lịch hẹn.');
        }
        if($book->status == 3){
            return redirect('/admin/book')->with('error', 'Lịch hẹn này đã bị hủy.');
        }

        if($book->status == 2){
            $book->update(['status'=>4]);
        }
        $examinationResult = ExaminationResult::where('book_id', $book->id)->first();
        return view('admin.book.start-examination', compact('book', 'examinationResult'));
    }

    public function handleExamination(Request $request, Book $book){
        $re_examination_date = $request->re_examination_date;
        $re_examination_date_format = null;

        if($re_examination_date){
            $today = Carbon::today();
            $re_examination_date_format = Carbon::createFromFormat('d-m-Y', $re_examination_date);
            if ($re_examination_date_format->lt($today)) {
                return redirect()->back()->with(['warning' => 'Không được chọn ngày trong quá khứ.']);
            }
        }

        $diagnose = $request->input('diagnose');
        $clinical_examination = $request->input('clinical_examination');
        $conclude = $request->input('conclude');
        $treatment = $request->input('treatment');
        $medicine = $request->input('medicine');
        $action = $request->input('action');

        if($action === 'waiting_result'){
            $book->update(['status'=>5]);
        }
        else{
            $book->update(['status'=>6]);
        }

        if ($action == 'return_result_to_email') {
            $email = $book->email;
            $patient_name = $book->name;
            $examination_date = date('d/m/Y', $book->date_examination_int);
            $book_code = $book->book_code;
            $lookup_url = route('look_appointment');

            $data = [
                'book_code' => $book_code,
                'patient_name' => $patient_name,
                'examination_date' => $examination_date,
                'diagnose' => $diagnose,
                'clinical_examination' => $clinical_examination,
                'conclude' => $conclude,
                'treatment' => $treatment,
                'medicine' => $medicine,
                're_examination_date' => $re_examination_date_format ? $re_examination_date_format->format('d/m/Y') : null,
                'lookup_url' => $lookup_url
            ];
            Mail::to($email)->send(new SendMailResultExamination($data));
        }

        ExaminationResult::updateOrCreate(
            ['book_id' => $book->id],
            [
                'diagnose' => $diagnose,
                'clinical_examination' => $clinical_examination,
                'conclude' => $conclude,
                'treatment' => $treatment,
                'medicine' => $medicine,
                're_examination_date' => $re_examination_date_format?->timestamp,
                'created_date_int' => time()
            ]
        );

        return redirect()->route('book.index')->with('success', 'Đã cập nhật kết quả khám bệnh.');
    }

    public function printResultPDF(Book $book){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        if($isDoctor && $user->doctor->id != $book->doctor_id){
            return abort(404);
        }

        if($book->status != 6){
            return redirect()->route('book.index')->with(['error' => 'Chưa có kết quả khám bệnh.']);
        }

        $site = Site::first();
        $doctor = $book->doctor?->name;
        $specialty = $book->specialty?->name;
        $date_examination = $book->date_examination;
        $hour_examination = $book->appointment?->hour_examination;
        $doctor_specialty = $specialty ? "$doctor - $specialty" : $doctor;
        $time_examination = $hour_examination ? "$hour_examination - $date_examination" : $date_examination;
        $today = 'Ngày ' . now()->day . ' tháng ' . now()->month . ' năm ' . now()->year;

        $examinationResult = ExaminationResult::where('book_id', $book->id)->first();

        $data = [
            'address_clinic' => $site->address,
            'hotline' => $site->hotline,
            'book_code' => $book->book_code,
            'patient_name' => $book->name,
            'patient_birth' => $book->birth,
            'patient_gender' => $book->gender == 1 ? 'Nam' : 'Nữ',
            'patient_address' => $book->address,
            'patient_email' => $book->email,
            'patient_phone' => $book->phone,
            'doctor' => $doctor,
            'doctor_specialty' => $doctor_specialty,
            'time_examination' => $time_examination,
            'today' => $today,
            'diagnose' => $examinationResult->diagnose,
            'clinical_examination' => $examinationResult->clinical_examination,
            'conclude' => $examinationResult->conclude,
            'treatment' => $examinationResult->treatment,
            'medicine' => $examinationResult->medicine,
            're_examination_date' => $examinationResult->re_examination_date_format ? $examinationResult->re_examination_date_format->format('d/m/Y') : null,
        ];

        $pdf = Pdf::loadView('admin.book.print', $data);
        return $pdf->stream('phieu-ket-qua-' . time() . '.pdf');
    }
}
