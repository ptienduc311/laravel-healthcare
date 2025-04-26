<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorPrize;
use App\Models\DoctorTraining;
use App\Models\DoctorWork;
use App\Models\Image;
use App\Models\MedicalSpecialty;
use Illuminate\Http\Request;
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

        $mdical_specialties = MedicalSpecialty::where('status', 1)->orderByDesc('created_date_int')->get();

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

        $doctors = $query->orderByDesc('created_date_int')->paginate(10)->withQueryString();
        return view('admin.doctor.list', compact('mdical_specialties', 'academicTitles', 'degrees', 'doctors'));
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
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg'
            ],
            [
                'name' => "Tên bác sĩ",
                'experience' => "Số năm kinh nghiệm",
                'avatar' => 'Ảnh đại diện'
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
                'created_by'=> 1
            ]);
            $image_id = $key->id;
        }

        $name = $request->input('name');
        $slug_name = Str::slug($request->input('name'));
        $specialty_id = $request->input('specialty_id');
        $experience = $request->input('experience');
        $academic_title = $request->input('academic_title');
        $degree = $request->input('degree');
        $regency = $request->input('regency');
        $introduce = $request->input('introduce');
        $status = $request->has('status') ? 1 : 2;
        $created_by = 1;
        $doctor = Doctor::create([
            'name' => $name,
            'slug_name' => $slug_name,
            'image_id' => $image_id,
            'specialty_id' => $specialty_id ?? null,
            'experience' => $experience,
            'academic_title' => $academic_title,
            'degree' => $degree,
            'regency' => $regency,
            'introduce' => $introduce,
            'status' => $status,
            'created_by' => $created_by,
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
        $doctor = Doctor::find($id);
        $specialties = MedicalSpecialty::where('status', 1)->get();
        return view('admin.doctor.edit', compact('doctor', 'specialties'));
    }

    public function update(Request $request, string $id)
    {
        $doctor = Doctor::with('doctor_prizes', 'doctor_training', 'doctor_works')->find($id);
        $oldImage = $doctor->image;
        $image_id = $oldImage->id ?? null;

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'experience' => 'nullable|string|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg'
            ],
            [
                'name' => "Tên bác sĩ",
                'experience' => "Số năm kinh nghiệm",
                'avatar' => 'Ảnh đại diện'
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
                'created_by'=> 1
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
        $specialty_id = $request->input('specialty_id');
        $experience = $request->input('experience');
        $academic_title = $request->input('academic_title');
        $degree = $request->input('degree');
        $regency = $request->input('regency');
        $introduce = $request->input('introduce');
        $status = $request->has('status') ? 1 : 2;
        $created_by = 1;
        $doctor->update([
            'name' => $name,
            'slug_name' => $slug_name,
            'image_id' => $image_id,
            'specialty_id' => $specialty_id ?? null,
            'experience' => $experience,
            'academic_title' => $academic_title,
            'degree' => $degree,
            'regency' => $regency,
            'introduce' => $introduce,
            'status' => $status,
            'created_by' => $created_by,
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

        return redirect('admin/doctor')->with('success', 'Cập nhật thành công');
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);
        $doctor->doctor_prizes()->delete();
        $doctor->doctor_training()->delete();
        $doctor->doctor_works()->delete();
        $doctor->delete();
        $oldImage = $doctor->image;
        if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
            Storage::disk('public')->delete($oldImage->src);
            $oldImage->delete();
        }
        return redirect('admin/doctor')->with('success', 'Đã xóa thành công');
    }
}
