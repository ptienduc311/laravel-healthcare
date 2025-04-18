<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontedController extends Controller
{
    public function index()
    {
        return view('themes.home');
    }

    public function listDoctor(){
        return view('themes.list-doctor');
    }

    public function doctor(){
        return view('themes.doctor');
    }

    public function newsSummary(){
        return view('themes.news-summary');
    }

    public function newsList(){
        return view('themes.news-list');
    }

    public function newsDetail(){
        return view('themes.news-detail');
    }

    public function book(){
        return view('themes.book');
    }
}
