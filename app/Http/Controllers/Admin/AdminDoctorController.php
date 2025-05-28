<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMailCancelBook;
use App\Models\Doctor;
use App\Models\DoctorPrize;
use App\Models\DoctorTraining;
use App\Models\DoctorWork;
use App\Models\Image;
use App\Models\MedicalSpecialty;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminDoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->query('specialty_id')) {
            $query->where('specialty_id', $request->specialty_id);
        }

        if ($request->query('academic_title')) {
            $query->where('academic_title', $request->academic_title);
        }

        if ($request->query('degree')) {
            $query->where('degree', $request->degree);
        }
        
        if ($request->query('status')) {
            $query->where('status', $request->status);
        }

        if ($request->query('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $medical_specialties = MedicalSpecialty::orderByDesc('created_date_int')->whereIn('status', [1, 2])->limit(15)->get();

        //Học hàm, học vị
        $academicTitles = [
            1 => 'Giáo sư',
            2 => 'Phó giáo sư',
        ];
        
        $degrees = [
            1 => 'Bác sĩ nội trú',
            2 => 'Bác sĩ',
            3 => 'Tiến sĩ',
            4 => 'Thạc sĩ',
            5 => 'Bác sĩ chuyên khoa II',
            6 => 'Bác sĩ chuyên khoa I',
            7 => 'Bác sĩ cao cấp',
        ];

        $doctors = $query->whereIn('status', [1, 2])->orderByDesc('created_date_int')->paginate(5)->withQueryString();
        return view('admin.doctor.list', compact('medical_specialties', 'academicTitles', 'degrees', 'doctors'));
    }

    public function show($doctorId = null){
        //Học hàm, học vị
        $academicTitles = [
            1 => 'Giáo sư',
            2 => 'Phó giáo sư',
        ];
        
        $degrees = [
            1 => 'Bác sĩ nội trú',
            2 => 'Bác sĩ',
            3 => 'Tiến sĩ',
            4 => 'Thạc sĩ',
            5 => 'Bác sĩ chuyên khoa II',
            6 => 'Bác sĩ chuyên khoa I',
            7 => 'Bác sĩ cao cấp',
        ];
        $specialties = MedicalSpecialty::where('status', 1)->get();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        $isAdmin = $user->hasRole('admin');

        //Doctor
        if ($isDoctor) {
            $doctor = Doctor::where('user_id', Auth::id())->whereIn('status', [1, 2])->first();

            if (!$doctor) {
                abort(404);
            }

            return view('admin.doctor.info', compact('doctor', 'academicTitles', 'degrees', 'specialties', 'isAdmin'));
        }

        //Admin
        if ($doctorId) {
            $doctor = Doctor::where('id', $doctorId)->whereIn('status', [1, 2])->first();

            if (!$doctor) {
                abort(404);
            }

            return view('admin.doctor.info', compact('doctor', 'academicTitles', 'degrees', 'specialties', 'isAdmin'));
        }

        return view('admin.doctor.info', compact('academicTitles', 'degrees', 'specialties', 'isAdmin'));
    }

    public function create()
    {
        $specialties = MedicalSpecialty::where('status', 1)->get();
        return view('admin.doctor.add', compact('specialties'));
    }

    public function store(Request $request)
    {
        $image_id = null;
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'experience' => 'nullable|string|max:255',
                'gender' => 'required', 
                'email' => 'nullable|string|email|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg',
                'string' => ':attribute phải là chuỗi',
                'email' => ':attribute không đúng định dạng',
            ],
            [
                'name' => "Tên bác sĩ",
                'experience' => "Số năm kinh nghiệm",
                'avatar' => "Ảnh đại diện",
                'gender' => "Giới tính",
                'email' => "Email"
            ]
        );

        $validator->after(function ($validator) use ($request) {
            $hasTrainingProcess = $request->has('time_training_process') || $request->has('content_training_process');
            $hasWorkProcess = $request->has('time_work_process') || $request->has('content_work_process');
        
            if ($hasTrainingProcess) {
                foreach ($request->input('time_training_process', []) as $key => $time) {
                    $content = $request->input("content_training_process.$key");
                    if ($time && !$content) {
                        $validator->errors()->add("training_process.$key", "Vui lòng nhập nội dung đào tạo.");
                    }
                }
            }

            if ($hasWorkProcess) {
                foreach ($request->input('time_work_process', []) as $key => $time) {
                    $content = $request->input("content_work_process.$key");
                    if ($time && !$content) {
                        $validator->errors()->add("work_process.$key", "Vui lòng nhập nội dung công tác.");
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd($request);

        if ($request->hasFile('avatar')) {
            $image = $request->avatar;
            $name = time() . '_' . $image->getClientOriginalName();
            $size = $image->getSize();
            $path = $image->storeAs('uploads', $name, 'public');
            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
            ]);
            $image_id = $key->id;
        }

        $name = $request->input('name');
        $slug_name = Str::slug($request->input('name'));
        $gender = $request->input('gender');
        $address = $request->input('address');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $current_workplace = $request->input('current_workplace');
        $specialty_id = $request->input('specialty_id');
        $experience = $request->input('experience');
        $academic_title = $request->input('academic_title');
        $degree = $request->input('degree');
        $regency = $request->input('regency');
        $introduce = $request->input('introduce');
        $status = $request->has('status') ? 1 : 2;
        $is_outstanding = $request->has('is_outstanding') ? 1 : 2;
        $doctor = Doctor::create([
            'name' => $name,
            'slug_name' => $slug_name,
            'image_id' => $image_id,
            'gender' => $gender,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'current_workplace' => $current_workplace,
            'specialty_id' => $specialty_id ?? null,
            'experience' => $experience,
            'academic_title' => $academic_title,
            'degree' => $degree,
            'regency' => $regency,
            'introduce' => $introduce,
            'status' => $status,
            'is_outstanding' => $is_outstanding,
            'created_date_int' => time()
        ]);
        $doctor_id = $doctor->id;

        $time_training_process = $request->input('time_training_process');
        $content_training_process = $request->input('content_training_process');
        $time_work_process = $request->input('time_work_process');
        $content_work_process = $request->input('content_work_process');
        $content_prize = $request->input('content_prize');

        if(is_array($time_training_process) && is_array($content_training_process)){
            foreach($time_training_process as $index => $time){
                if(!empty($time) || !empty($content_training_process[$index])){
                    DoctorTraining::create([
                        'time_training' => $time,
                        'content_training' => $content_training_process[$index],
                        'doctor_id' => $doctor_id,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        if(is_array($time_work_process) && is_array($content_work_process)){
            foreach($time_work_process as $index => $time){
                if(!empty($time) || !empty($content_work_process[$index])){
                    DoctorWork::create([
                        'time_work' => $time,
                        'content_work' => $content_work_process[$index],
                        'doctor_id' => $doctor_id,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        if(is_array($content_prize)){
            foreach($content_prize as $index => $content){
                if(!empty($content)){
                    DoctorPrize::create([
                        'content_prize' => $content,
                        'doctor_id' => $doctor_id,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        return redirect('admin/doctor')->with('success', 'Đã thêm mới thành công');
    }

    public function edit(string $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');
        
        $doctor = Doctor::where('id', $id)->whereIn('status', [1, 2])->first();
        $specialties = MedicalSpecialty::where('status', 1)->get();
        return view('admin.doctor.edit', compact('doctor', 'specialties', 'isAdmin'));
    }

    public function update(Request $request, string $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isDoctor = $user->hasRole('doctor');
        $isAdmin = $user->hasRole('admin');

        $doctor = Doctor::find($id);
        $oldImage = $doctor->image;
        $image_id = $oldImage->id ?? null;

        if($isDoctor && $doctor->status != 1){
            return redirect()->back()->with('error', 'Bác sĩ đã bị tạm dừng hoạt động');
        }

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'experience' => 'nullable|string|max:255',
                'gender' => 'required',
                'email' => 'nullable|string|email|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg',
                'string' => ':attribute phải là chuỗi',
                'email' => ':attribute không đúng định dạng',
            ],
            [
                'name' => "Tên bác sĩ",
                'experience' => "Số năm kinh nghiệm",
                'avatar' => 'Ảnh đại diện',
                'gender' => "Giới tính",
                'email' => "Email"
            ]
        );

        $validator->after(function ($validator) use ($request) {
            $hasTrainingProcess = $request->has('time_training_process') || $request->has('content_training_process');
            $hasWorkProcess = $request->has('time_work_process') || $request->has('content_work_process');
        
            if ($hasTrainingProcess) {
                foreach ($request->input('time_training_process', []) as $key => $time) {
                    $content = $request->input("content_training_process.$key");
                    if ($time && !$content) {
                        $validator->errors()->add("training_process.$key", "Vui lòng nhập nội dung đào tạo.");
                    }
                }
            }

            if ($hasWorkProcess) {
                foreach ($request->input('time_work_process', []) as $key => $time) {
                    $content = $request->input("content_work_process.$key");
                    if ($time && !$content) {
                        $validator->errors()->add("work_process.$key", "Vui lòng nhập nội dung công tác.");
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('avatar')) {
            $image = $request->avatar;
            $name = time() . '_' . $image->getClientOriginalName();
            $size = $image->getSize();
            $path = $image->storeAs('uploads', $name, 'public');
            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
            ]);
            $image_id = $key->id;

            if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
                Storage::disk('public')->delete($oldImage->src);
                $oldImage->delete();
            }
        }
        elseif ($request->input('remove_image') == 1 && $oldImage) {
            if (Storage::disk('public')->exists($oldImage->src)) {
                Storage::disk('public')->delete($oldImage->src);
            }
            $oldImage->delete();
            $image_id = null;
        }

        $name = $request->input('name');
        $slug_name = Str::slug($request->input('name'));
        $gender = $request->input('gender');
        $address = $request->input('address');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $current_workplace = $request->input('current_workplace');
        $specialty_id = $request->input('specialty_id');
        $experience = $request->input('experience');
        $academic_title = $request->input('academic_title');
        $degree = $request->input('degree');
        $regency = $request->input('regency');
        $introduce = $request->input('introduce');
        $status = $doctor->status;
        $is_outstanding = $doctor->is_outstanding;
        if($isAdmin){
            $status = $request->has('status') ? 1 : 2;
            $is_outstanding = $request->has('is_outstanding') ? 1 : 2;
        }

        $doctor->update([
            'name' => $name,
            'slug_name' => $slug_name,
            'image_id' => $image_id,
            'gender' => $gender,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'current_workplace' => $current_workplace,
            'specialty_id' => $specialty_id ?? null,
            'experience' => $experience,
            'academic_title' => $academic_title,
            'degree' => $degree,
            'regency' => $regency,
            'introduce' => $introduce,
            'status' => $status,
            'is_outstanding' => $is_outstanding,
        ]);

        $time_training_process = $request->input('time_training_process');
        $content_training_process = $request->input('content_training_process');
        $time_work_process = $request->input('time_work_process');
        $content_work_process = $request->input('content_work_process');
        $content_prize = $request->input('content_prize');

        //Xóa tất cả dữ liệu trong bảng liên quan rồi cập nhật
        $doctor->doctor_prizes()->delete();
        $doctor->doctor_training()->delete();
        $doctor->doctor_works()->delete();

        if(is_array($time_training_process) && is_array($content_training_process)){
            foreach($time_training_process as $index => $time){
                if(!empty($time) || !empty($content_training_process[$index])){
                    DoctorTraining::create([
                        'time_training' => $time,
                        'content_training' => $content_training_process[$index],
                        'doctor_id' => $id,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        if(is_array($time_work_process) && is_array($content_work_process)){
            foreach($time_work_process as $index => $time){
                if(!empty($time) || !empty($content_work_process[$index])){
                    DoctorWork::create([
                        'time_work' => $time,
                        'content_work' => $content_work_process[$index],
                        'doctor_id' => $id,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        if(is_array($content_prize)){
            foreach($content_prize as $index => $content){
                if(!empty($content)){
                    DoctorPrize::create([
                        'content_prize' => $content,
                        'doctor_id' => $id,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function destroy(Request $request, string $id)
    {
        $doctor = Doctor::where('id', $id)->whereIn('status', [1, 2])->first();
        if (!$doctor) {
            return redirect()->back()->with('error', 'Không tìm thấy bác sĩ.');
        }

        $action = $request->query('action');
        $today = Carbon::today()->timestamp;
        $books = $doctor->books()
        ->where('date_examination_int', '>=', $today)
        ->whereIn('status', [1, 2])
        ->get();

        $site = Site::first();
        $email_web = $site?->email;
        $phone = $site?->phone;
        $hotline = $site?->hotline;

        foreach ($books as $book) {
            $data = [
                'name' => $book->name,
                'book_code' => $book->book_code,
                'time_examination' => $book->appointment?->hour_examination,
                'doctor_name' => $book->doctor?->name,
                'specialty' => $book->specialty?->name,
                'reason' => "Bác sĩ thay đổi lịch làm việc.",
                'email_web' => $email_web,
                'phone' => $phone,
                'hotline' => $hotline
            ];
            Mail::to($book->email)->send(new SendMailCancelBook($data));
            $book->status = 3;
            $book->save();
        }

        if ($doctor->account) {
            $action = $request->query('action');
            $user = $doctor->account;

            if ($action === 'create_new') {
                $doctor->update(['status' => 3, 'user_id' => NULL]);

                $slugName = Str::slug($user->name);
                Doctor::create([
                    'name' => $user->name,
                    'slug_name' => $slugName,
                    'status' => 1,
                    'created_date_int' => time(),
                    'user_id' => $user->id,
                ]);

                return redirect()->back()->with('success', 'Đã xóa và tạo bác sĩ mới thành công.');
            }

            if ($action === 'delete_account') {
                $doctor->update(['status' => 3, 'user_id' => NULL]);
                $user->roles()->detach();
                $user->delete();
                return redirect()->back()->with('success', 'Đã xóa bác sĩ và tài khoản liên kết thành công.');
            }
        }

        $doctor->update(['status' => 3]);
        return redirect()->back()->with('success', 'Đã xóa bác sĩ thành công.');
    }

    public function getDoctors(Request $request)
    {
        $specialty_id = $request->query('specialty_id');
        $name = $request->query('name');

        if(!$specialty_id && !$name){
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn chuyên khoa hoặc nhập tên bác sĩ.'
            ]);
        }

        $query = Doctor::query();

        if ($specialty_id) {
            $query->where('specialty_id', $specialty_id);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $doctors = $query->whereIn('status', [1, 2])->get();

        if ($doctors->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy bác sĩ phù hợp.'
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

    public function getDoctorsConnect(Request $request){
        $specialty_id = $request->query('specialty_id');
        $name = $request->query('name');

        if(!$specialty_id && !$name){
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng chọn chuyên khoa hoặc nhập tên bác sĩ.'
            ]);
        }

        $query = Doctor::whereNull('user_id')->whereIn('status', [1, 2]);

        if ($specialty_id) {
            $query->where('specialty_id', $specialty_id);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $doctors = $query->get();

        if ($doctors->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy bác sĩ phù hợp.'
            ]);
        }

        $data = $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'avatar_url' => $doctor->avatar_url,
                'status' => $doctor->status
            ];
        });

        return response()->json([
            'status' => 'success',
            'doctors' => $data
        ]);
    }

    public function showProfile(Request $request)
    {
        $doctorId = $request->query('doctorId');
        $doctor = Doctor::with(['specialty', 'doctor_training', 'doctor_works', 'doctor_prizes'])->find($doctorId);

        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy bác sĩ phù hợp.'
            ]);
        }

        $academicTitles = [
            'PGS' => 'Phó Giáo Sư',
            'GS'  => 'Giáo Sư',
            'TS'  => 'Tiến Sĩ',
            'ThS' => 'Thạc Sĩ',
        ];

        $degrees = [
            'BS'   => 'Bác Sĩ',
            'BSCKI' => 'Bác Sĩ Chuyên Khoa I',
            'BSCKII' => 'Bác Sĩ Chuyên Khoa II',
        ];

        $html = view('admin.doctor.partials.doctor_profile', compact('doctor', 'academicTitles', 'degrees'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

}
