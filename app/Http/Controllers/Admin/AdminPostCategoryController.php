<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PostCategory::limit(10)->offset(0)->get();
        return view('admin.post.listCat', compact('categories'));
    }

    public function create()
    {
        // $category = PostCategory::
        return view('admin.post.addCat');
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $status = $request->has('status') ? 1 : 0;
        $slug = Str::slug($request->input('name'));

        PostCategory::create([
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'created_date_int' => time()
        ]);
        return redirect('admin/post/cat')->with('status', 'Đã thêm mới thành công');
    }

    public function edit(string $id)
    {
        $category = PostCategory::find($id);
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
        $status = $request->has('status') ? 1 : 0;
        $slug = Str::slug($request->input('name'));

        PostCategory::find($id)->update([
            'name' => $name,
            'slug' => $slug,
            'status' => $status,
            'created_date_int' => time()
        ]);

        return redirect('admin/post/cat')->with('status', 'Đã cập nhật thành công');
    }

    public function destroy(string $id)
    {
        $category = PostCategory::findOrFail($id)->delete();
        return redirect('admin/post/cat')->with('status', 'Đã xóa thành công');
    }
}
