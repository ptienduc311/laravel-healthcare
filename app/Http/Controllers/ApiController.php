<?php

namespace App\Http\Controllers;

use App\Mail\SendMailBook;
use App\Models\Appointment;
use App\Models\Book;
use App\Models\Districts;
use App\Models\Doctor;
use App\Models\MedicalSpecialty;
use App\Models\Provinces;
use App\Models\Wards;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function getProvince(){
        try {
            $provinces = Provinces::all();
            if ($provinces->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Không có dữ liệu tỉnh/thành phố'], 404);
            }
            return response()->json(['status' => 'success', 'data' => $provinces]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }
    
    public function getDistrict(Request $request){
        try {
            $province_id = $request->province_id;
            $districts = Districts::where('province_id', $province_id)->get();
            if ($districts->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Không có dữ liệu quận/huyện'], 404);
            }
            return response()->json(['status' => 'success', 'data' => $districts]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }
    
    public function getWard(Request $request){
        try {
            $district_id = $request->district_id;
            $wards = Wards::where('district_id', $district_id)->get();
            if ($wards->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Không có dữ liệu phường/xã'], 404);
            }
            return response()->json(['status' => 'success', 'data' => $wards]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }    

    public function getAvailabelTimes(Request $request){
        $doctorId = $request->doctor_id;
        $date = $request->date;
    
        if (!$doctorId || !$date) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn bác sĩ và ngày khám.'
            ], 200);
        }
    
        try {
            $timestamp = Carbon::createFromFormat('Y-m-d', $date)->startOfDay()->timestamp;
    
            if ($timestamp < Carbon::now()->startOfDay()->timestamp) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng chọn ngày khám bắt đầu từ ngày hôm nay.'
                ], 200);
            }
    
            $appointments = Appointment::where('doctor_id', $doctorId)
                ->where('day_examination', $timestamp)->where('status', 1)
                ->orderBy('hour_examination')
                ->get(['id', 'hour_examination', 'is_appointment']);
    
            return response()->json([
                'status' => 'success',
                'data' => $appointments,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi xử lý dữ liệu.'
            ], 200);
        }
    }

    public function saveBook(Request $request){
        // dd($request);
        $name = $request->name;
        $phone = $request->phone;
        $birth = Carbon::parse($request->birth)->format('d/m/Y');
        $email = $request->email;
        $gender = $request->gender;
        $address = $request->address;
        $appointmentDate = $request->appointmentDate;
        $date_examination = Carbon::parse($appointmentDate)->format('d/m/Y');
        $date_examination_int = Carbon::parse($appointmentDate)->startOfDay()->timestamp;
        $appointment_id = $request->appointment_id;
        $reason = $request->reason;
        $doctor_id = $request->doctor_id;
        $specialty_id = $request->specialty_id;
        $province_id = $request->province_id;
        $district_id = $request->district_id;
        $ward_id = $request->ward_id;
        $today = Carbon::today()->startOfDay();;
        // dd($name, $phone, $birth, $email, $gender, $address, $appointmentDate,
        // $date_examination, $appointment_id, $reason, $doctor_id, $specialty_id,
        // $province_id, $district_id, $ward_id, $today);

        //Kiểm tra ngày và lịch hẹn
        if(Carbon::parse($appointmentDate)->lt($today)){
            return redirect()->back()->with('error', 'Vui lòng chọn ngày khám bắt đầu từ ngày hôm nay trở đi.');
        }
        $appointment = Appointment::where('id', $appointment_id)->first();
        if($appointment->is_appointment == 1){
            return redirect()->back()->with('error', 'Thời gian khám này đã có người đăng ký.');
        }

        //Tạo mã khám bệnh và lưu lịch hẹn
        do {
            $book_code = strtoupper(Str::random(12));
        } while (Book::where('book_code', $book_code)->exists());
        Book::create([
            'book_code' => $book_code,
            'name' => $name,
            'phone' => $phone,
            'birth' => $birth,
            'email' => $email,
            'gender' => $gender,
            'date_examination' => $date_examination,
            'date_examination_int' => $date_examination_int,
            'address' => $address,
            'reason' => $reason,
            'created_date_int' => time(),
            'province_id' => $province_id ,
            'district_id' => $district_id ,
            'ward_id' => $ward_id ,
            'appointment_id' => $appointment_id ,
            'specialty_id' => $specialty_id ,
            'doctor_id' => $doctor_id ,
        ]);

        //Cập nhật lịch hẹn
        Appointment::where('id', $appointment_id)->update([
            'is_appointment' => 1
        ]);

        //Gửi email
        $province = Provinces::find($province_id);
        $district = Districts::find($district_id);
        $ward = Wards::find($ward_id);
        $doctor = Doctor::find($doctor_id);
        $specialty = MedicalSpecialty::find($specialty_id);
        $appointment = Appointment::find($appointment_id);
        $appointment_date = Carbon::parse($appointmentDate)->format('d/m/Y');
        $link_confirm_book = route('book.confirm', $book_code);

        $data = [
            'book_code' => $book_code,
            'name' => $name,
            'birth' => $birth,
            'phone' => $phone,
            'email' => $email,
            'gender' => $gender,
            'address_common' => $ward->name . ', ' . $district->name . ', ' . $province->name,
            'address' => $address,
            'reason' => $reason,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment->hour_examination,
            'doctor_name' => $doctor->name,
            'specialty_name' => $specialty_id ? $specialty->name : '',
            'link_confirm_book' => $link_confirm_book,
        ];
        Mail::to($email)->send(new SendMailBook($data));
        return redirect()->back()->with('success', 'Vui lòng kiểm tra email để xác nhận lịch hẹn.')
        ->with('patient_info', [
            'name' => $name,
            'phone' => $phone,
            'birth' => $birth,
            'email' => $email,
            'gender' => $gender,
            'address' => $address,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'ward_id' => $ward_id,
        ]);
    }
    
    public function confirmBook(string $code){
        $exists = Book::where('book_code', $code)->exists();
        if ($exists) {
            $book = Book::where('book_code', $code)->first();
            if ($book->status == 1) {
                $book->status = 2;
                $book->save();
                return redirect('tra-cuu-lich-hen')->with('success', 'Đã xác nhận lịch hẹn thành công.');
            } else {
                return redirect('tra-cuu-lich-hen')->with('error', 'Lịch hẹn đã được xác nhận từ trước.');
            }
        } else {
            return redirect('tra-cuu-lich-hen')->with('error', 'Không tồn tại lịch hẹn này.');
        }
    }

    public function getBookAppointment(Request $request){
        $booking_token = $request->query('booking_token');
        $email = $request->query('email');
        $appointment_date = $request->query('appointment_date');

        $query = Book::with(['doctor', 'specialty', 'appointment', 'result_examination']);

        if ($booking_token) {
            $query->where('book_code', $booking_token);
        } elseif ($email && $appointment_date) {
            $query->where('email', $email)
                ->where('date_examination', Carbon::parse($appointment_date)->format('d/m/Y'));
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Thông tin không hợp lệ.'
            ]);
        }

        $book = $query->get();
        if ($book->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $book
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy lịch hẹn.'
        ]);
    }

    public function getDoctors(Request $request){
        $specialty_id = $request->query('specialty_id');
        $doctors = Doctor::where('specialty_id', $specialty_id)->where('status', 1)->get();
        if ($doctors->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn chuyên khoa khác.'
            ]);
        }

        $data = $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'avatar_url' => $doctor->avatar_url,
            ];
        });

        return response()->json([
            'status' => 'success',
            'doctors' => $data
        ]);
    }

    public function cancelBook(Request $request){
        $bookingId =  $request->bookingId;
        $bookingCode =  $request->bookingCode;
        $book = Book::where('id', $bookingId)->where('book_code', $bookingCode)->first();

        if(empty($book)){
            return response()->json([
                'type' => 'error',
                'message' => 'Không tìm thấy lịch hẹn.'
            ]);
        }
        if($book->status == 3){
            return response()->json([
                'type' => 'error',
                'message' => 'Lịch hẹn này đã được hủy trước đó.',
                'status' => 3
            ]);
        }
        if(in_array($book->status, [4, 5, 6])){
            return response()->json([
                'type' => 'error',
                'message' => 'Lịch hẹn này không được hủy.',
                'status' => $book->status
            ]);
        }

        $book->status = 3;
        $book->save();
        return response()->json([
            'type' => 'success',
            'message' => 'Đã hủy lịch hẹn thành công.',
            'status' => 3
        ]);
    }
}
