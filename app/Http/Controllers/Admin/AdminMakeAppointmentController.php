<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalSpecialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMakeAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $today = strtotime(date('Y-m-d'));
        $dateFilter = $request->query('date');
        
        // B1: Lấy danh sách doctorId duy nhất theo filter
        $doctorIds = Appointment::when($request->query('keyword'), function ($query) use ($request) {
            $query->whereHas('doctor', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        })
        ->when($request->query('date'), function ($query) use ($request) {
            $timestamp = Carbon::createFromFormat('d-m-Y', $request->query('date'))->startOfDay()->timestamp;
            $query->where('day_examination', $timestamp);
        })
        ->select('doctor_id')
        ->distinct()
        ->pluck('doctor_id');

        // B2: Phân trang doctor theo danh sách đã lọc
        $paginator = Doctor::whereIn('id', $doctorIds)->paginate(10);

        // B3: Lấy lịch hẹn chỉ cho các doctor trong trang hiện tại
        $currentDoctorIds = $paginator->pluck('id');

        $appointments = Appointment::with(['doctor', 'user'])
        ->whereIn('doctor_id', $currentDoctorIds)
        ->when($request->query('date'), function ($query) use ($request) {
            $timestamp = Carbon::createFromFormat('d-m-Y', $request->query('date'))->startOfDay()->timestamp;
            $query->where('day_examination', $timestamp);
        })
        ->get()
        ->groupBy('doctor_id');

        // B4: Group tiếp theo ngày như cũ
        $groupedAppointments = $appointments->map(function ($items) use ($today) {
        return $items->groupBy('day_examination')->sortKeysDesc()->sortKeysUsing(function ($a, $b) use ($today) {
            if ($a == $today) return -1;
            if ($b == $today) return 1;
            return $b <=> $a;
        });
        });

        return view('admin.appointment.list', compact('groupedAppointments', 'paginator'));
    }

    public function create($doctorId = null)
    {
        $type = null;
        $specialties = MedicalSpecialty::where('status', 1)->get();
        $doctor = Doctor::findOrFail($doctorId);
        return view('admin.appointment.add', compact('doctor', 'specialties', 'type'));
    }

    public function store(Request $request, string $doctorId)
    {
        // dd($request);
        $request->validate(
            [
                'day_examination' => 'required|date_format:d-m-Y',
                'hour_examination' => 'required|array|min:1',
                'hour_examination.*' => 'required|string',
            ],
            [
                'day_examination.required' => 'Vui lòng chọn ngày khám.',
                'day_examination.date_format' => 'Định dạng ngày không hợp lệ.',
                'hour_examination.required' => 'Vui lòng chọn ít nhất một giờ khám.',
                'hour_examination.array' => 'Dữ liệu giờ khám không hợp lệ.',
            ]
        );

        $created_by = Auth::id();
        $day_examination = Carbon::createFromFormat('d-m-Y', $request->day_examination)->startOfDay()->timestamp;

        foreach ($request->hour_examination as $hour) {
            Appointment::create([
                'doctor_id' => $doctorId,
                'hour_examination' => $hour,
                'day_examination' => $day_examination,
                'is_appointment' => 2,
                'created_by' => $created_by,
                'created_date_int' => time(),
            ]);
        }

        return redirect('admin/doctor')->with('success', 'Thêm lịch khám thành công!');
    }

    public function edit(string $doctorId, string $date)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $appointments = Appointment::where('doctor_id', $doctorId)->where('day_examination', $date)->get();
        if($appointments->isEmpty()){
            return abort(404);
        }
        return view('admin.appointment.edit', compact('appointments', 'doctor', 'doctorId', 'date'));
    }

    public function update(Request $request, string $doctorId, string $date)
    {
        $request->validate(
            [
                'day_examination' => 'required|date_format:d-m-Y',
                'hour_examination' => 'required|array|min:1',
                'hour_examination.*' => 'required|string',
            ],
            [
                'day_examination.required' => 'Vui lòng chọn ngày khám.',
                'day_examination.date_format' => 'Định dạng ngày không hợp lệ.',
                'hour_examination.required' => 'Vui lòng chọn ít nhất một giờ khám.',
                'hour_examination.array' => 'Dữ liệu giờ khám không hợp lệ.',
            ]
        );

        $day_examination = Carbon::createFromFormat('d-m-Y', $request->day_examination)->startOfDay()->timestamp;
        if($date != $day_examination){
            return back()->withErrors(['day_examination' => 'Không được thay đổi ngày khám.'])->withInput();
        }
        $created_by = Auth::id();
        
        Appointment::where('doctor_id', $doctorId)
        ->where('day_examination', $date)
        ->delete();
        foreach ($request->hour_examination as $hour) {
            Appointment::create([
                'doctor_id' => $doctorId,
                'hour_examination' => $hour,
                'day_examination' => $day_examination,
                'is_appointment' => 2,
                'created_by' => $created_by,
                'created_date_int' => time(),
            ]);
        }

        return redirect('admin/doctor')->with('success', 'Cập nhật lịch khám thành công!');
    }   

    public function destroy(string $doctorId, string $date)
    {
        
    }
}
