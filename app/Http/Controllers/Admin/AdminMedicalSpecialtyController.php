<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Image;
use App\Models\MedicalSpecialty;
use App\Models\PageSpecialty;
use App\Models\ServiceSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminMedicalSpecialtyController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalSpecialty::query();
        
        if ($request->query('status')) {
            $query->where('status', $request->status);
        }

        if ($request->query('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $medical_specialties = $query->whereIn('status', [1, 2])->orderByDesc('created_date_int')->paginate(10)->withQueryString();
        return view('admin.medical_specialty.list', compact('medical_specialties'));
    }

    public function create()
    {
        return view('admin.medical_specialty.add');
    }

    public function store(Request $request)
    {
        $image_id = null;
        $image_icon_id = null;
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg'
            ],
            [
                'name' => "Tên chuyên khoa",
                'image' => 'Ảnh chuyên khoa',
                'image_icon' => "Ảnh icon chuyên khoa"
            ]
        );

        if ($request->hasFile('image')) {
            $image = $request->image;
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

        if ($request->hasFile('image_icon')) {
            $image = $request->image_icon;
            $name = time() . '_' . $image->getClientOriginalName();
            $size = $image->getSize();
            $path = $image->storeAs('uploads', $name, 'public');

            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
            ]);
            $image_icon_id = $key->id;
        }

        $name = $request->input('name');
        $slug = Str::slug($request->input('name'));
        $status = $request->has('status') ? 1 : 2;
        MedicalSpecialty::create([
            'name' => $name,
            'slug' => $slug,
            'image_icon_id' => $image_icon_id,
            'image_id' => $image_id,
            'status' => $status,
            'created_date_int' => time()
        ]);
        return redirect('admin/medical-specialty')->with('success', 'Đã thêm mới thành công');
    }

    public function edit(string $id)
    {
        $medical_specialty = MedicalSpecialty::where('id', $id)->whereIn('status', [1, 2])->first();
        if (!$medical_specialty) {
            return redirect('admin/medical-specialty')->with('error', 'Không tìm thấy chuyên khoa');
        }
        return view('admin.medical_specialty.edit', compact('medical_specialty'));
    }

    public function update(Request $request, string $id)
    {
        $medical_specialty = MedicalSpecialty::find($id);
        $oldImage = $medical_specialty->image;
        $image_id = $oldImage->id ?? null;

        $oldImageIcon = $medical_specialty->image_icon;
        $image_icon_id = $oldImageIcon->id ?? null;

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg'
            ],
            [
                'name' => "Tên chuyên khoa",
                'image' => 'Ảnh chuyên khoa',
                'image_icon' => 'Ảnh icon chuyên khoa'
            ]
        );

        //Ảnh icon chuyên khoa
        if ($request->hasFile('image_icon')) {
            $medical_specialty->update([
                'image_icon_id' => NULL,
            ]);
            
            $image = $request->file('image_icon');
            $name = time() . '_' . $image->getClientOriginalName();
            $size = $image->getSize();
            $path = $image->storeAs('uploads', $name, 'public');
            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
            ]);
            $image_icon_id = $key->id;
            $medical_specialty->image_icon_id = $image_icon_id;
            $medical_specialty->save();

            if ($oldImageIcon && Storage::disk('public')->exists($oldImageIcon->src)) {
                Storage::disk('public')->delete($oldImageIcon->src);
                $oldImageIcon->delete();
            }
        }
        elseif ($request->input('remove_image_icon') == 1 && $oldImageIcon) {
            return back()
            ->withErrors(['image_icon' => 'Bạn cần chọn ảnh chuyên khoa'])
            ->withInput();
        }

        //Ảnh chuyên khoa
        if ($request->hasFile('image')) {
            $medical_specialty->update([
                'image_id' => NULL,
            ]);
            
            $image = $request->file('image');
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
            $medical_specialty->image_id = $image_id;
            $medical_specialty->save();

            if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
                Storage::disk('public')->delete($oldImage->src);
                $oldImage->delete();
            }
        }
        elseif ($request->input('remove_image') == 1 && $oldImage) {
            return back()
            ->withErrors(['image' => 'Bạn cần chọn ảnh chuyên khoa'])
            ->withInput();
        }

        $name = $request->input('name');
        $slug = Str::slug($request->input('name'));
        $status = $request->has('status') ? 1 : 2;
        $medical_specialty->update([
            'name' => $name,
            'slug' => $slug,
            'image_icon_id' => $image_icon_id,
            'image_id' => $image_id,
            'status' => $status,
        ]);
        return redirect('admin/medical-specialty')->with('success', 'Đã thêm mới thành công');
    }

    public function destroy(string $id)
    {
        $medical_specialty = MedicalSpecialty::where('id', $id)->whereIn('status', [1, 2])->first();
        if (!$medical_specialty) {
            return redirect()->back()->with('error', 'Không tìm thấy chuyên khoa.');
        }

        // $page_specialty = PageSpecialty::where('medical_specialty_id', $id)->first();
        // $oldImage = $medical_specialty->image;
        // $oldImageIcon = $medical_specialty->image_icon;
        // $oldImageDesc = optional($page_specialty)->image;
        // if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
        //     Storage::disk('public')->delete($oldImage->src);
        //     $oldImage->delete();
        // }
        // if ($oldImageIcon && Storage::disk('public')->exists($oldImageIcon->src)) {
        //     Storage::disk('public')->delete($oldImageIcon->src);
        //     $oldImageIcon->delete();
        // }
        // if ($oldImageDesc && Storage::disk('public')->exists($oldImageDesc->src)) {
        //     Storage::disk('public')->delete($oldImageDesc->src);
        //     $oldImageDesc->delete();
        // }
        // ServiceSpecialty::where('medical_specialty_id', $id)->delete();
        // optional($page_specialty)->delete();
        // $medical_specialty->delete();

        $medical_specialty->update(['status' => 3]);
        Doctor::where('specialty_id', $id)->update(['specialty_id' => null]);
        return redirect()->back()->with('success', 'Đã xóa thành công');
    }

    public function info_page(){
        $medical_specialties = MedicalSpecialty::whereIn('status', [1, 2])->orderByDesc('created_date_int')->get();
        return view('admin.medical_specialty.info_page', compact('medical_specialties'));
    }

    //Tìm kiếm chuyên khoa
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $medical_specialties = MedicalSpecialty::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        })->whereIn('status', [1, 2])->orderByDesc('created_date_int')->get();

        // Render dữ liệu
        $html = view('admin.medical_specialty.partials.list', compact('medical_specialties'))->render();

        return response()->json(['html' => $html]);
    }

    //Lấy dữ liệu chuyên khoa
    public function select_page_specialty_handle(Request $request){
        $page_id = $request->page_id;

        $medical_specialty = MedicalSpecialty::where('id', $page_id)->whereIn('status', [1, 2])->first();
        if($medical_specialty){
            $page_specialty = PageSpecialty::where('medical_specialty_id', $page_id)->first();
            $service_specialty = ServiceSpecialty::where('medical_specialty_id', $page_id)->get();

            $result = [
                'name' => $medical_specialty->name,
                'service_id' => $medical_specialty->id,
                'page_specialty' => $page_specialty ? $page_specialty : null,
                'services' => $service_specialty->isNotEmpty() ? $service_specialty : null,
            ];

            return response()->json([
                'status' => 'success',
                'result' => $result
                ]
            );
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy chuyên khoa'
                ]
            );
        }
    }

    //Cập nhật trang chuyên khoa
    public function info_page_handle(Request $request){
        if (!$request->filled('specialty_id')) {
            return back()->with('error', 'Bạn chưa chọn chuyên khoa.');
        }

        $specialtyId = $request->input('specialty_id');
        PageSpecialty::updateOrCreate(
            ['medical_specialty_id' => $specialtyId],
            [
                'description' => $request->input('description'),
                'content' => $request->input('content'),
                'created_date_int' => time(),
            ]
        );

        ServiceSpecialty::where('medical_specialty_id', $specialtyId)->delete();
        // Tạo mới danh sách dịch vụ
        $names = $request->input('name_service');
        $descriptions = $request->input('description_service');        

        if (is_array($names) && is_array($descriptions)) {
            foreach ($names as $index => $name) {
                if (!empty($name) && !empty($descriptions[$index])) {
                    ServiceSpecialty::create([
                        'name' => $name,
                        'description' => $descriptions[$index],
                        'medical_specialty_id' => $specialtyId,
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Đã lưu thông tin trang chuyên khoa thành công.');
    }
}
