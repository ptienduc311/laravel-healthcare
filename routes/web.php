<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMedicalSpecialty;
use App\Http\Controllers\Admin\AdminPostCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\FrontedController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontedController::class, 'index']);
Route::get('doi-ngu-chuyen-gia', [FrontedController::class, 'listDoctor']);
Route::get('doi-ngu-chuyen-gia/{slug}', [FrontedController::class, 'doctor']);
Route::get('dat-lich-kham', [FrontedController::class, 'book']);
Route::get('tin-tong-hop', [FrontedController::class, 'newsSummary']);
Route::get('{slug}', [FrontedController::class, 'newsList']);
Route::get('tin-tuc/{slug}', [FrontedController::class, 'newsDetail']);

// Route::middleware(['auth', 'checkAdminRole'])->group(function () {
    #ADMIN
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    
    //PostCategory
    Route::get('admin/post/cat', [AdminPostCategoryController::class, 'index'])->name('post_category.index');
    Route::get('admin/post/cat/add', [AdminPostCategoryController::class, 'create'])->name('post_category.add');
    Route::post('admin/post/cat/store', [AdminPostCategoryController::class, 'store'])->name('post_category.store');
    Route::get('admin/post/cat/edit/{id}', [AdminPostCategoryController::class, 'edit'])->name('post_category.edit');
    Route::post('admin/post/cat/update/{id}', [AdminPostCategoryController::class, 'update'])->name('post_category.update');
    Route::get('admin/post/cat/destroy/{id}', [AdminPostCategoryController::class, 'destroy'])->name('post_category.destroy');
    
    //Post
    Route::get('admin/post', [AdminPostController::class, 'index'])->name('post.index');
    Route::get('admin/post/add', [AdminPostController::class, 'create'])->name('post.add');
    Route::post('admin/post/store', [AdminPostController::class, 'store'])->name('post.store');
    Route::get('admin/post/edit/{id}', [AdminPostController::class, 'edit'])->name('post.edit');
    Route::post('admin/post/update/{id}', [AdminPostController::class, 'update'])->name('post.update');
    Route::get('admin/post/destroy/{id}', [AdminPostController::class, 'destroy'])->name('post.destroy');  
    
    //Medical specialty
    Route::get('admin/medical-specialty', [AdminMedicalSpecialty::class, 'index'])->name('medical-specialty.index');
    Route::get('admin/medical-specialty/add', [AdminMedicalSpecialty::class, 'create'])->name('medical-specialty.add');
    Route::post('admin/medical-specialty/store', [AdminMedicalSpecialty::class, 'store'])->name('medical-specialty.store');
    Route::get('admin/medical-specialty/edit/{id}', [AdminMedicalSpecialty::class, 'edit'])->name('medical-specialty.edit');
    Route::post('admin/medical-specialty/update/{id}', [AdminMedicalSpecialty::class, 'update'])->name('medical-specialty.update');
    Route::get('admin/medical-specialty/destroy/{id}', [AdminMedicalSpecialty::class, 'destroy'])->name('medical-specialty.destroy');  
    Route::get('admin/medical-specialty/info-page', [AdminMedicalSpecialty::class, 'info_page'])->name('medical-specialty.info-page');
    Route::post('admin/medical-specialty/info-page-handle', [AdminMedicalSpecialty::class, 'info_page_handle'])->name('medical-specialty.info-page-handle');
    
    Route::post('admin/medical-specialty/select-service-handle', [AdminMedicalSpecialty::class, 'select_service_handle'])->name('medical-specialty.select-service-handle');
    Route::post('admin/medical-specialty/search', [AdminMedicalSpecialty::class, 'search'])->name('medical-specialty.search');

    //Upload image
    Route::post('/upload-image', [UploadController::class, 'upload']);

// });