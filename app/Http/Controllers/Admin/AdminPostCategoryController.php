<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
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
        $slug = Str::slug($request->input('name'));
        $status = $request->has('status') ? 1 : 2;

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
        $category = PostCategory::findOrFail($id);
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

        $postCategory = PostCategory::findOrFail($id);
        $postCategoryKhac = PostCategory::where('slug', 'khac')->first();
        if($postCategoryKhac && $postCategory->id == $postCategoryKhac->id){
            return redirect('admin/post/cat')->with('error', 'Không được cập nhật danh mục này');
        }

        $name = $request->input('name');
        $status = $request->has('status') ? 1 : 2;
        $slug = Str::slug($request->input('name'));

        $postCategory->update([
            'name' => $name,
            'slug' => $slug,
            'status' => $status
        ]);

        return redirect('admin/post/cat')->with('success', 'Đã cập nhật thành công');
    }

    public function destroy(string $id)
    {
        $postCategory = PostCategory::findOrFail($id);
        $postCategoryKhac = PostCategory::where('slug', 'khac')->first();
        if($postCategoryKhac && $postCategory->id == $postCategoryKhac->id){
            return redirect('admin/post/cat')->with('error', 'Không được xóa danh mục này');
        }
        
        if( Post::where('category_id', $id)->exists()){
            if(!$postCategoryKhac){
                return redirect('admin/post/cat')->with('error', 'Vui lòng tạo danh mục "Khác" để lưu trữ bài viết trước khi xóa danh mục này');
            }
            Post::where("category_id", $id)->update(['category_id' => $postCategoryKhac->id]);
        }

        $postCategory->delete();
        return redirect('admin/post/cat')->with('success', 'Đã xóa thành công');
    }
}