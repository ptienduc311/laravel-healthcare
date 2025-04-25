<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        $categories = PostCategory::where('status', 1)
            ->orderBy('created_date_int', 'desc')
            ->limit(15)
            ->get();

        $query = Post::with(['image', 'category', 'user']);

        if ($request->query('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->query('status')) {
            $query->where('status', $request->status);
        }

        if ($request->query('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $posts = $query->orderByDesc('created_date_int')->paginate(10)->withQueryString();

        return view('admin.post.list', compact('categories', 'posts'));
    }

    public function create()
    {
        $categories = PostCategory::where('status', 1)
        ->orderBy('created_date_int', 'desc')
        ->limit(15)
        ->get();
        return view('admin.post.add', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $image_id = null;
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'content' => 'required',
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg'
            ],
            [
                'title' => "Tiêu đề bài viết",
                'description' => "Mô tả bài viết",
                'content' => 'Nội dung bài viết',
                'category_id' => 'Danh mục bài viết',
                'image' => 'Ảnh bìa'
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
                'created_by'=> 1
            ]);
            $image_id = $key->id;
        }

        $title = $request->input('title');
        $slug = Str::slug($request->input('title'));
        $description = $request->input('description');
        $content = $request->input('content');
        $status = $request->has('status') ? 1 : 2;
        $category_id = $request->input('category_id');
        $created_by = 1;
        Post::create([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'content' => $content,
            'status' => $status,
            'category_id' => $category_id,
            'image_id' => $image_id,
            'created_by' => $created_by,
            'created_date_int' => time()
        ]);
        return redirect('admin/post')->with('status', 'Đã thêm mới thành công');
    }

    public function edit(string $id)
    {
        $categories = PostCategory::where('status', 1)
        ->orderBy('created_date_int', 'desc')
        ->limit(15)
        ->get();
        $post = Post::find($id);
        return view('admin.post.edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $oldImage = $post->image;
        $image_id = $oldImage->id ?? null;

        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'content' => 'required',
                'category_id' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'image' => 'File được chọn không phải dạng ảnh',
                'mimes' => ':attribute phải thuộc các loại sau jpg,png,jpeg,gif,svg'
            ],
            [
                'title' => "Tiêu đề bài viết",
                'description' => "Mô tả bài viết",
                'content' => 'Nội dung bài viết',
                'category_id' => 'Danh mục bài viết',
                'image' => 'Ảnh bìa'
            ]
        );

        if ($request->hasFile('image')) {
            $post->update([
                'image_id' => null,
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
                'created_by'=> 1
            ]);
            $image_id = $key->id;

            if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
                Storage::disk('public')->delete($oldImage->src);
                $oldImage->delete();
            }
        }
        elseif ($request->input('remove_image') == 1 && $oldImage) {
            return back()
            ->withErrors(['image' => 'Bạn cần chọn ảnh bìa.'])
            ->withInput();
        }

        $title = $request->input('title');
        $slug = Str::slug($request->input('title'));
        $description = $request->input('description');
        $content = $request->input('content');
        $status = $request->has('status') ? 1 : 2;
        $category_id = $request->input('category_id');
        $created_by = 1;
        $post->update([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'content' => $content,
            'status' => $status,
            'category_id' => $category_id,
            'image_id' => $image_id,
            'created_by' => $created_by
        ]);

        return redirect('admin/post')->with('status', 'Đã cập nhật thành công');
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        $oldImage = $post->image;
        if ($oldImage && Storage::disk('public')->exists($oldImage->src)) {
            Storage::disk('public')->delete($oldImage->src);
            $oldImage->delete();
        }
        return redirect('admin/post')->with('status', 'Đã xóa thành công');
    }
}
