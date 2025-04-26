<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PostCategory::query();
        if ($request->query('status')) {
            $query->where('status', $request->status);
        }

        if ($request->query('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        $categories = $query->orderByDesc('created_date_int')->paginate(10)->withQueryString();
        return view('admin.post.listCat', compact('categories'));
    }

    public function create()
    {
        // dd(Auth::user());
        return view('admin.post.addCat');
    }
    
    public function store(Request $request)
    {   
        $request->validate(
            [
                'name' => 'required|string|max:255'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => "Tên danh mục",
            ]
        );

        $name = $request->input('name');
        $status = $request->has('status') ? 1 : 2;
        $slug = Str::slug($request->input('name'));

        PostCategory::create([
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'created_date_int' => time()
        ]);
        return redirect('admin/post/cat')->with('success', 'Đã thêm mới thành công');
    }

    public function edit(string $id)
    {
        $category = PostCategory::find($id);
        // dd($category);
        return view('admin.post.editCat', compact('category'));
    } 

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => "Tên danh mục",
            ]
        );

        $name = $request->input('name');
        $status = $request->has('status') ? 1 : 2;
        $slug = Str::slug($request->input('name'));

        PostCategory::find($id)->update([
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'created_date_int' => time()
        ]);

        return redirect('admin/post/cat')->with('success', 'Đã cập nhật thành công');
    }

    public function destroy(string $id)
    {
        PostCategory::findOrFail($id)->delete();
        return redirect('admin/post/cat')->with('success', 'Đã xóa thành công');
    }
}
