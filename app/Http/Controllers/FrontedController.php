<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalSpecialty;
use App\Models\PageSpecialty;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\ServiceSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $doctors = Doctor::where('status', 1)->where('is_outstanding', 1)->orderByDesc('created_date_int')->limit(8)->get();
        $specialties = MedicalSpecialty::where('status', 1)->get();

        return view('themes.home', compact('posts', 'doctors', 'specialties'));
    }

    public function listDoctor(Request $request){
        $specialties = MedicalSpecialty::where('status', 1)->get();
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

        $query = Doctor::query();

        if ($request->query('specialty_id')) {
            $query->where('specialty_id', $request->specialty_id);
        }
    
        if ($request->query('acedemic_id')) {
            $query->where('academic_title', $request->acedemic_id);
        }
    
        if ($request->query('degree_id')) {
            $query->where('degree', $request->degree_id);
        }
    
        $doctors = $query->where('status', 1)->orderbyDesc('created_date_int')->paginate(12)->withQueryString();

        return view('themes.list-doctor', compact('doctors', 'specialties', 'academicTitles', 'degrees'));
    }

    public function doctor(string $slug){
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
        $doctor = Doctor::where('slug_name', $slug)->where('status', 1)->firstOrFail();
        return view('themes.doctor', compact('doctor', 'academicTitles', 'degrees'));
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
        ->paginate(10)->withQueryString();
        
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
        $specialties = MedicalSpecialty::where('status', 1)->get();
        return view('themes.book', compact('specialties'));
    }

    public function lookAppointment(){
        return view('themes.look-appointment');
    }

    public function introduce(){
        return view('themes.introduce');
    }

    public function specialty(){
        $specialties = MedicalSpecialty::where('status', 1)->orderByDesc('created_date_int')->get();
        return view('themes.specialty', compact('specialties'));
    }

    public function specialtyPage(string $slug){
        $specialty = MedicalSpecialty::where('slug', $slug)
            ->where('status', 1)
            ->with(['pageSpecialty', 'serviceSpecialties'])
            ->firstOrFail();

        $page_specialty = $specialty->pageSpecialty;
        $services = $specialty->serviceSpecialties;

        $list_lastest_news = Post::where('status', 1)->latest()->limit(5)->get();
        $doctors = Doctor::where('specialty_id', $specialty->id)->orderByDesc('created_date_int')->limit(10)->get();
        return view('themes.specialty-page', compact('specialty', 'page_specialty', 'services', 'list_lastest_news', 'doctors'));
    }

    public function searchDoctor(Request $request){
        $keyword = $request->query('keyword');
        $doctors = Doctor::where('name', 'like', '%' . $keyword . '%')->where('status', 1)->orderByDesc('created_date_int')->paginate(10)->withQueryString();

        $total_post = Post::where('title', 'like', '%' . $keyword . '%')->where('status', 1)->count();
        $total_doctor = Doctor::where('name', 'like', '%' . $keyword . '%')->where('status', 1)->count();
        $total = $total_post + $total_doctor;

        $list_lastest_news = Post::where('status', 1)->latest()->limit(5)->get();
        $list_featured_news = Post::where('status', 1)->where('is_outstanding', 1)->latest()->limit(5)->get();

        return view('themes.search-doctor', compact('doctors', 'keyword', 'total_post', 'total_doctor', 'total', 'list_lastest_news', 'list_featured_news'));
    }
    
    public function searchPost(Request $request){
        $keyword = $request->query('keyword');
        $posts = Post::where('title', 'like', '%' . $keyword . '%')->where('status', 1)->orderByDesc('created_date_int')->paginate(10)->withQueryString();

        $total_post = Post::where('title', 'like', '%' . $keyword . '%')->where('status', 1)->count();
        $total_doctor = Doctor::where('name', 'like', '%' . $keyword . '%')->where('status', 1)->count();
        $total = $total_post + $total_doctor;

        $list_lastest_news = Post::where('status', 1)->latest()->limit(5)->get();
        $list_featured_news = Post::where('status', 1)->where('is_outstanding', 1)->latest()->limit(5)->get();

        return view('themes.search-post', compact('posts', 'keyword', 'total_post', 'total_doctor', 'total', 'list_lastest_news', 'list_featured_news'));
    }
}
