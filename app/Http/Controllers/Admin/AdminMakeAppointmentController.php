<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMailCancelBook;
use App\Models\Appointment;
use App\Models\Book;
use App\Models\Doctor;
use App\Models\DoctorAppointments;
use App\Models\MedicalSpecialty;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminMakeAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $startDate = null;
        $endDate = null;

        if ($request->query('start_date')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay()->timestamp;
        }

        if ($request->query('end_date')) {
            $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->startOfDay()->timestamp;
        }

        $appointments = Appointment::select('doctor_id', 'day_examination')
        ->selectRaw("GROUP_CONCAT(hour_examination ORDER BY hour_examination ASC SEPARATOR ', ') as hours")
        ->selectRaw('COUNT(id) as total_appointments')
        ->when($startDate, fn ($q) => $q->where('day_examination', '>=', $startDate))
        ->when($endDate, fn ($q) => $q->where('day_examination', '<=', $endDate))
        ->when($request->keyword, function ($query) use ($request) {
            $query->whereIn('doctor_id', function ($subQuery) use ($request) {
                $subQuery->select('id')
                    ->from('doctors')
                    ->where('name', 'like', '%' . $request->keyword . '%');
            });
        })
        ->groupBy('doctor_id', 'day_examination')
        ->orderByRaw("
            CASE 
                WHEN day_examination = UNIX_TIMESTAMP(CURDATE()) THEN 0 
                ELSE 1 
            END
        ")
        ->orderByDesc('created_date_int')
        ->paginate(10)->withQueryString();;

        return view('admin.appointment.list', compact('appointments'));
    }

    public function create($doctorId = null)
    {
        // $type = null;
        // $specialties = MedicalSpecialty::where('status', 1)->get();
        // $doctor = Doctor::findOrFail($doctorId);
        // return view('admin.appointment.add', compact('doctor', 'specialties', 'type'));

        $specialties = MedicalSpecialty::where('status', 1)->get();

        // if (auth()->user()->hasRole('admin')) {
            if (!$doctorId) {
                // Chưa chọn bác sĩ thì hiển thị trang tìm kiếm
                return view('admin.appointment.add', compact('specialties'));
            }
            $doctor = Doctor::findOrFail($doctorId);
        // } else {
        //     // Nếu là bác sĩ đăng nhập thì tự lấy bản thân
        //     $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        // }

        return view('admin.appointment.add', compact('doctor', 'specialties'));
    }

    public function store(Request $request, string $doctorId)
    {
        $request->validate(
            [
                'day_examination' => 'required|date_format:d-m-Y',
                'hour_examination' => 'required|array|min:1',
                'hour_examination.*' => 'required|string',
                'type' => 'required|in:15,30,60,120',
                'doctor_id' => 'required|exists:doctors,id',
            ],
            [
                'required' => ':attribute không được để trống.',
                'date_format' => ':attribute không đúng định dạng d-m-Y.',
                'array' => ':attribute phải là mảng hợp lệ.',
                'min' => ':attribute phải có ít nhất :min phần tử.',
                'string' => ':attribute phải là chuỗi.',
                'in' => ':attribute không hợp lệ.',
                'exists' => ':attribute không tồn tại trong hệ thống.',
            ],
            [
                'day_examination' => 'Ngày khám',
                'hour_examination' => 'Giờ khám',
                'hour_examination.*' => 'Giờ khám chi tiết',
                'type' => 'Khoảng thời gian',
                'doctor_id' => 'Bác sĩ',
            ]
        );

        $doctor = Doctor::where('id', $request->doctor_id)->where('status', 1)->first();
        if (!$doctor) {
            return redirect()->back()->withErrors(['doctor_id' => 'Bác sĩ đã bị vô hiệu hóa.'])->withInput();
        }

        $today = Carbon::today()->startOfDay();;
        $day_examination = Carbon::createFromFormat('d-m-Y', $request->day_examination)->startOfDay();
        if ($day_examination->lt($today)) {
            return redirect()->back()->withErrors(['day_examination' => 'Không được chọn ngày trong quá khứ.'])->withInput();
        }
        $day_examination_int = $day_examination->timestamp;

        $checkAppointment = DoctorAppointments::where('doctor_id', $doctorId)->where('day_examination', $day_examination_int)->first();
        if($checkAppointment){
            return redirect()->back()->with('error', 'Đã có lịch khám của ngày ' . $request->day_examination);
        }

        $created_by = Auth::id();
        $type = $request->input('type');

        DoctorAppointments::create([
            'doctor_id' => $doctor->id,
            'day_examination' => $day_examination_int,
            'type' => $type,
            'created_by' => $created_by,
            'created_date_int' => time(),
        ]);

        foreach ($request->hour_examination as $hour) {
            Appointment::create([
                'doctor_id' => $doctorId,
                'hour_examination' => $hour,
                'day_examination' => $day_examination_int,
                'is_appointment' => 2,
                'created_by' => $created_by,
                'created_date_int' => time(),
            ]);
        }

        return redirect()->back()->with('success', 'Thêm lịch khám thành công!');
    }

    public function edit(string $doctorId, string $date)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $appointments = DoctorAppointments::where('doctor_id', $doctorId)->where('day_examination', $date)->first();
        if(!$appointments){
            return abort(404);
        }
        $type = $appointments->type;
        return view('admin.appointment.edit', compact('type', 'doctor', 'doctorId', 'date'));
    }

    public function update(Request $request, string $doctorId, string $date)
    {
        $request->validate(
            [
                'day_examination' => 'required|date_format:d-m-Y',
                'hour_examination' => 'required|array|min:1',
                'hour_examination.*' => 'required|string',
                'type' => 'required|in:15,30,60,120',
                'doctor_id' => 'required|exists:doctors,id',
            ],
            [
                'required' => ':attribute không được để trống.',
                'date_format' => ':attribute không đúng định dạng d-m-Y.',
                'array' => ':attribute phải là mảng hợp lệ.',
                'min' => ':attribute phải có ít nhất :min phần tử.',
                'string' => ':attribute phải là chuỗi.',
                'in' => ':attribute không hợp lệ.',
                'exists' => ':attribute không tồn tại trong hệ thống.',
            ],
            [
                'day_examination' => 'Ngày khám',
                'hour_examination' => 'Giờ khám',
                'hour_examination.*' => 'Giờ khám chi tiết',
                'type' => 'Khoảng thời gian',
                'doctor_id' => 'Bác sĩ',
            ]
        );

        //Kiểm tra bác sĩ
        $doctor = Doctor::where('id', $request->doctor_id)->where('status', 1)->first();
        if (!$doctor) {
            return redirect()->back()->withErrors(['doctor_id' => 'Bác sĩ đã bị vô hiệu hóa.'])->withInput();
        }

        //Kiểm tra lịch hẹn cũ không
        $today = Carbon::today()->startOfDay();;
        $day_examination_check = Carbon::createFromFormat('d-m-Y', $request->day_examination)->startOfDay();
        if ($day_examination_check->lt($today)) {
            return redirect()->back()->with('error', 'Không được cập nhật lịch hẹn cũ!');
        }

        $day_examination = Carbon::createFromFormat('d-m-Y', $request->day_examination)->startOfDay()->timestamp;
        if($date != $day_examination){
            return back()->withErrors(['day_examination' => 'Không được thay đổi ngày khám.'])->withInput();
        }

        //Kiểm tra giờ đã chọn
        $newHours = $request->input('hour_examination');
        $existingHours = Appointment::where('doctor_id', $doctorId)
            ->where('day_examination', $date)
            ->pluck('hour_examination')
            ->toArray();

        $removedHours = array_diff($existingHours, $newHours);
        $hoursAdd = array_diff($newHours, $existingHours);
        $type = $request->input('type');
        // dd($removedHours, $hoursAdd);

        if($removedHours){
            $appointmentsConfirm = Appointment::where('doctor_id', $doctorId)
                ->where('day_examination', $date)
                ->whereIn('hour_examination', $removedHours)
                ->where('is_appointment', 1)
                ->get();

            if ($appointmentsConfirm->isNotEmpty()) {
                $hoursAppointment = $appointmentsConfirm->pluck('hour_examination')->toArray();
                $appointmentIds = $appointmentsConfirm->pluck('id')->toArray();
                // dd($hoursAppointment, $appointmentIds);
                return redirect()
                    ->route('appointment.edit', ['doctorId' => $doctorId, 'date' => $date])
                    ->with([
                        'confirm_remove' => true,
                        'type' => $type,
                        'newHours' => $newHours,
                        'hoursAdd' => $hoursAdd,
                        'hoursAppointment' => $hoursAppointment,
                        'appointmentIds' => $appointmentIds,
                        'date' => $date,
                        'doctorId' => $doctorId,
                    ]);
            }
        }

        $created_by = Auth::id();

        DoctorAppointments::where('doctor_id', $doctor->id)
            ->where('day_examination', $day_examination)
            ->update([
                'type' => $type
            ]);

        Appointment::where('doctor_id', $doctorId)
            ->where('day_examination', $date)
            ->whereNotIn('hour_examination', $newHours)
            ->delete();

        foreach ($hoursAdd as $hour) {
            Appointment::create([
                'doctor_id' => $doctorId,
                'hour_examination' => $hour,
                'day_examination' => $day_examination,
                'is_appointment' => 2,
                'created_by' => $created_by,
                'created_date_int' => time(),
            ]);
        }

        return redirect('admin/appointment')->with('success', 'Cập nhật lịch khám thành công!');
    }

    public function destroy(string $doctorId, string $date)
    {
        
    }

    public function checkAppointment(Request $request){
        // dd($request);
         $request->validate([
            'doctor_id' => 'required|integer',
            'day_examination' => 'required|date_format:d-m-Y'
        ]);

        $timestamp = Carbon::createFromFormat('d-m-Y', $request->day_examination)->startOfDay()->timestamp;

        $doctorSchedule = DoctorAppointments::where('doctor_id', $request->doctor_id)
            ->where('day_examination', $timestamp)
            ->first();

        if (!$doctorSchedule) {
            return response()->json(['status' => 'error', 'message' => 'Không có lịch khám.']);
        }

        $appointments = Appointment::where('doctor_id', $request->doctor_id)
            ->where('day_examination', $timestamp)
            ->get(['hour_examination', 'is_appointment']);

        $formattedAppointments = $appointments->map(function ($item) {
            return [
                'time' => $item->hour_examination,
                'is_appointment' => $item->is_appointment == 1 ? true : false,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'type' => $doctorSchedule->type,
                'hour_examinations' => $formattedAppointments
            ]
        ]);
    }

    public function confirmRemove(Request $request)
    {
        $doctorId = $request->doctor_id;
        $day_examination = $request->date;
        $type = $request->type;
        $newHours = $request->newHours;
        $hoursAdd = $request->input('hoursAdd', []);
        $hoursAppointment = $request->hoursAppointment;
        $appointmentIds = $request->appointmentIds;
        $created_by = Auth::id();

        $site = Site::first();
        $email_web = $site->email;
        $phone = collect([$site?->phone, $site?->hotline])->filter()->implode(' - ');

        //Thông báo hủy qua email bệnh nhân
        foreach($appointmentIds as $key => $item){
            $book = Book::where('appointment_id', $item)->where('doctor_id', $doctorId)->first();
            $book->status = 3;
            $book->save();
            $data = [
                'name' => $book->name,
                'book_code' => $book->book_code,
                'time_examination' => $hoursAppointment[$key],
                'doctor_name' => $book->doctor?->name,
                'specialty' => $book->specialty?->name,
                'reason' => "Bác sĩ thay đổi lịch làm việc.",
                'email_web' => $email_web,
                'phone' => $phone
            ];
            // dd($book);
            Mail::to($book->email)->send(new SendMailCancelBook($data));
        }

        //Cập nhật lịch hẹn
        DoctorAppointments::where('doctor_id', $doctorId)
            ->where('day_examination', $day_examination)
            ->update(['type' => $type]);

        Appointment::where('doctor_id', $doctorId)
        ->where('day_examination', $day_examination)
        ->whereNotIn('hour_examination', $newHours)
        ->delete();

        foreach ($hoursAdd as $hour) {
            Appointment::create([
                'doctor_id' => $doctorId,
                'hour_examination' => $hour,
                'day_examination' => $day_examination,
                'is_appointment' => 2,
                'created_by' => $created_by,
                'created_date_int' => time(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Đã cập nhật lịch khám và xóa giờ đã chọn.']);
    }

}
