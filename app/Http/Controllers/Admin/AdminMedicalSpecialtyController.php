<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\MedicalSpecialty;
use App\Models\PageSpecialty;
use App\Models\ServiceSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $medical_specialties = $query->orderByDesc('created_date_int')->paginate(10)->withQueryString();
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
            $created_by = Auth::id();

            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
                'created_by'=> $created_by
            ]);
            $image_id = $key->id;
        }

        if ($request->hasFile('image_icon')) {
            $image = $request->image_icon;
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
            $image_icon_id = $key->id;
        }

        $name = $request->input('name');
        $slug = Str::slug($request->input('name'));
        $description = $request->input('description');
        $status = $request->has('status') ? 1 : 2;
        $created_by = Auth::id();
        MedicalSpecialty::create([
            'name' => $name,
            'slug' => $slug,
            'image_icon_id' => $image_icon_id,
            'image_id' => $image_id,
            'description' => $description,
            'status' => $status,
            'created_by' => $created_by,
            'created_date_int' => time()
        ]);
        return redirect('admin/medical-specialty')->with('success', 'Đã thêm mới thành công');
    }

    public function edit(string $id)
    {
        $medical_specialty = MedicalSpecialty::find($id);
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
            $created_by = Auth::id();
            $key = Image::create([
                'name' => $name,
                'src' => $path,
                'size' => $size,
                'type' => 1,
                'created_by'=> $created_by
            ]);
            $image_icon_id = $key->id;

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
        $description = $request->input('description');
        $status = $request->has('status') ? 1 : 2;
        $medical_specialty->update([
            'name' => $name,
            'slug' => $slug,
            'image_icon_id' => $image_icon_id,
            'image_id' => $image_id,
            'description' => $description,
            'status' => $status,
        ]);
        return redirect('admin/medical-specialty')->with('success', 'Đã thêm mới thành công');
    }

    public function destroy(string $id)
    {
        $medical_specialty = MedicalSpecialty::find($id);
        PageSpecialty::where('medical_specialty_id', $id)->delete();
        ServiceSpecialty::where('medical_specialty_id', $id)->delete();
        $medical_specialty->delete();
        $oldImage = $medical_specialty->image;
        if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
            Storage::disk('public')->delete($oldImage->src);
            $oldImage->delete();
        }
        return redirect('admin/medical-specialty')->with('success', 'Đã xóa thành công');
    }

    public function info_page(){
        $medical_specialties = MedicalSpecialty::orderByDesc('created_date_int')->get();
        return view('admin.medical_specialty.info_page', compact('medical_specialties'));
    }

    //Tìm kiếm chuyên khoa
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $medical_specialties = MedicalSpecialty::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        })->orderByDesc('created_date_int')->get();

        // Render dữ liệu
        $html = view('admin.medical_specialty.partials.list', compact('medical_specialties'))->render();

        return response()->json(['html' => $html]);
    }

    //Lấy dữ liệu chuyên khoa
    public function select_service_handle(Request $request){
        $service_id = $request->service_id;
        $image = null;

        $medical_specialty = MedicalSpecialty::find($service_id);
        $page_specialty = PageSpecialty::where('medical_specialty_id', $service_id)->first();
        if(!empty($page_specialty->image_id)){
            $image = $page_specialty->image->src;
        }
        $service_specialty = ServiceSpecialty::where('medical_specialty_id', $service_id)->get();

        $result = [
            'name' => $medical_specialty->name,
            'service_id' => $medical_specialty->id,
            'page_specialty' => $page_specialty ? $page_specialty : null,
            'services' => $service_specialty->isNotEmpty() ? $service_specialty : null,
            'image' => $image,
        ];

        return response()->json(['result' => $result]);
    }

    //Cập nhật trang chuyên khoa
    public function info_page_handle(Request $request){
        if (!$request->filled('specialty_id')) {
            return back()->with('error', 'Bạn chưa chọn chuyên khoa.');
        }

        $specialtyId = $request->input('specialty_id');
        $page = PageSpecialty::where('medical_specialty_id', $specialtyId)->first();
        $oldImage = $page ? $page->image : null;
        $image_id = $oldImage->id ?? null;

        if ($request->hasFile('image')) {
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

        $dataPage = [
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'medical_specialty_id' => $specialtyId,
            'created_by' => Auth::id(),
            'created_date_int' => time()
        ];
        if ($image_id) {
            $dataPage['image_id'] = $image_id;
        }

        if ($page) {
            $page->update($dataPage);
        } else {
            PageSpecialty::create($dataPage);
        }

        ServiceSpecialty::where('medical_specialty_id', $specialtyId)->delete();

        // Tạo mới danh sách dịch vụ
        $names = $request->input('name_service');
        $descriptions = $request->input('description_service');        

        if (is_array($names) && is_array($descriptions)) {
            foreach ($names as $index => $name) {
                if (!empty($name) || !empty($descriptions[$index])) {
                    ServiceSpecialty::create([
                        'name' => $name,
                        'description' => $descriptions[$index],
                        'medical_specialty_id' => $specialtyId,
                        'created_by' => Auth::id(),
                        'created_date_int' => time()
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Đã lưu thông tin trang chuyên khoa thành công.');
    }
}
