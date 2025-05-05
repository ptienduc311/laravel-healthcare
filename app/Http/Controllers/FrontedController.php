<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalSpecialty;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class FrontedController extends Controller
{
    public function index()
    {
        $category = PostCategory::where('slug', 'tin-y-khoa')->first();
        $posts = Post::when($category, function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->where('status', 1)
            ->orderByDesc('created_date_int')
            ->limit(4)
            ->get();

        $doctors = Doctor::where('status', 1)->orderByDesc('created_date_int')->limit(8)->get();
        $specialties = MedicalSpecialty::where('status', 1)->get();

        return view('themes.home', compact('posts', 'doctors', 'specialties'));
    }

    public function listDoctor(){
        return view('themes.list-doctor');
    }

    public function doctor(){
        return view('themes.doctor');
    }

    public function newsSummary(){
        $post_categories = PostCategory::with(['posts' => function($query){
            $query->where('status', 1)->latest()->take(5);
        }])->where('status', 1)->latest()->limit(5)->get();
        
        $list_lastest_news = Post::where('status', 1)->latest()->limit(10)->get();
        
        return view('themes.news-summary', compact('post_categories', 'list_lastest_news'));
    }

    public function newsList($slug){
        $post_category = PostCategory::where('slug', $slug)->firstOrFail();
        $posts = $post_category->posts()
        ->where('status', 1)
        ->orderByDesc('created_date_int')
        ->paginate(10);

        $list_lastest_news = Post::where('status', 1)->latest()->limit(5)->get();
        
        return view('themes.news-list', compact('post_category', 'posts', 'list_lastest_news'));
    }

    public function newsDetail($slug_id){
        $pos = strrpos($slug_id, '-');
        $slug = substr($slug_id, 0, $pos);
        $id = substr($slug_id, $pos + 1);
    
        $post = Post::where('slug', $slug)->where('id', $id)->firstOrFail();

        $list_related_news = Post::where('category_id', $post->category_id)
        ->where('id', '!=', $id)
        ->where('status', 1)
        ->latest()
        ->limit(5)
        ->get();

        $list_lastest_news = Post::where('status', 1)->latest()->limit(5)->get();

        return view('themes.news-detail', compact('post', 'list_related_news', 'list_lastest_news'));
    }

    public function book(){
        return view('themes.book');
    }
}
