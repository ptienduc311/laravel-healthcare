<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPostCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\FrontedController;
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
    Route::get('admin/post/cat', [AdminPostCategoryController::class, 'index']);
    Route::get('admin/post/cat/add', [AdminPostCategoryController::class, 'create'])->name('post_category.add');
    Route::post('admin/post/cat/store', [AdminPostCategoryController::class, 'store'])->name('post_category.store');
    Route::get('admin/post/cat/edit/{id}', [AdminPostCategoryController::class, 'edit'])->name('post_category.edit');
    Route::post('admin/post/cat/update/{id}', [AdminPostCategoryController::class, 'update'])->name('post_category.update');
    Route::get('admin/post/cat/destroy/{id}', [AdminPostCategoryController::class, 'destroy'])->name('post_category.destroy');
    //Post
    // Route::get('admin/post', [AdminPostController::class, 'list'])->middleware('can:post.view');
    // Route::get('admin/post/add', [AdminPostController::class, 'add'])->name('post.add')->middleware('can:post.add');
    // Route::post('admin/post/store', [AdminPostController::class, 'store'])->name('post.store')->middleware('can:post.add');
    // Route::get('admin/post/edit/{id}', [AdminPostController::class, 'edit'])->name('post.edit')->middleware('can:post.edit');
    // Route::post('admin/post/update/{id}', [AdminPostController::class, 'update'])->name('post.update')->middleware('can:post.edit');
    // Route::get('admin/post/delete/{id}', [AdminPostController::class, 'delete'])->name('post.delete')->middleware('can:post.delete');  
// });