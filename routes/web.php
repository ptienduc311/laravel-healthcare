<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDoctorController;
use App\Http\Controllers\Admin\AdminMakeAppointmentController;
use App\Http\Controllers\Admin\AdminMedicalSpecialtyController;
use App\Http\Controllers\Admin\AdminPostCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\FrontedController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

//Login
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login/handle', [LoginController::class, 'handle'])->name('login.handle');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

//Register
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('register/handle', [RegisterController::class, 'handle'])->name('register.handle');
Route::get('register/active/{confirm_token}', [RegisterController::class, 'active'])->name('register.active');

//Reset Password
Route::get('reset', [LoginController::class, 'reset'])->name('reset.pass');
Route::post('send-link-reset', [LoginController::class, 'sendLinkResetEmail'])->name('reset.send_code');
Route::get('new-pass/{reset_token}', [LoginController::class, 'newPass'])->name('new.pass');
Route::post('new-pass/{reset_token}', [LoginController::class, 'updatePass'])->name('update.pass');


Route::middleware(['auth', 'checkRole'])->group(function () {
    #ADMIN
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('admin/profile/update', [AdminController::class, 'profile_update'])->name('admin.profile_update');
    Route::get('admin/site', [AdminController::class, 'site'])->name('admin.site');
    Route::post('admin/site/update', [AdminController::class, 'site_update'])->name('admin.site_update');
    
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
    Route::get('admin/medical-specialty', [AdminMedicalSpecialtyController::class, 'index'])->name('medical-specialty.index');
    Route::get('admin/medical-specialty/add', [AdminMedicalSpecialtyController::class, 'create'])->name('medical-specialty.add');
    Route::post('admin/medical-specialty/store', [AdminMedicalSpecialtyController::class, 'store'])->name('medical-specialty.store');
    Route::get('admin/medical-specialty/edit/{id}', [AdminMedicalSpecialtyController::class, 'edit'])->name('medical-specialty.edit');
    Route::post('admin/medical-specialty/update/{id}', [AdminMedicalSpecialtyController::class, 'update'])->name('medical-specialty.update');
    Route::get('admin/medical-specialty/destroy/{id}', [AdminMedicalSpecialtyController::class, 'destroy'])->name('medical-specialty.destroy');  
    Route::get('admin/medical-specialty/info-page', [AdminMedicalSpecialtyController::class, 'info_page'])->name('medical-specialty.info-page');
    Route::post('admin/medical-specialty/info-page-handle', [AdminMedicalSpecialtyController::class, 'info_page_handle'])->name('medical-specialty.info-page-handle');
    Route::post('admin/medical-specialty/select-service-handle', [AdminMedicalSpecialtyController::class, 'select_service_handle'])->name('medical-specialty.select-service-handle');
    Route::post('admin/medical-specialty/search', [AdminMedicalSpecialtyController::class, 'search'])->name('medical-specialty.search');

    //Upload image
    Route::post('/upload-image', [UploadController::class, 'upload']);

    //Doctor
    Route::get('admin/doctor', [AdminDoctorController::class, 'index'])->name('doctor.index');
    Route::get('admin/doctor/add', [AdminDoctorController::class, 'create'])->name('doctor.add');
    Route::post('admin/doctor/store', [AdminDoctorController::class, 'store'])->name('doctor.store');
    Route::get('admin/doctor/edit/{id}', [AdminDoctorController::class, 'edit'])->name('doctor.edit');
    Route::post('admin/doctor/update/{id}', [AdminDoctorController::class, 'update'])->name('doctor.update');
    Route::get('admin/doctor/destroy/{id}', [AdminDoctorController::class, 'destroy'])->name('doctor.destroy');

    //Appointment
    Route::get('admin/appointment', [AdminMakeAppointmentController::class, 'index'])->name('appointment.index');
    Route::get('admin/appointment/add/{doctorId}', [AdminMakeAppointmentController::class, 'create'])->name('appointment.add');
    Route::post('admin/appointment/store/{doctorId}', [AdminMakeAppointmentController::class, 'store'])->name('appointment.store');
    Route::get('admin/appointment/edit/{doctorId}/{date}', [AdminMakeAppointmentController::class, 'edit'])->name('appointment.edit');
    Route::post('admin/appointment/update/{doctorId}/{date}', [AdminMakeAppointmentController::class, 'update'])->name('appointment.update');
    Route::get('admin/appointment/destroy/{doctorId}/{date}', [AdminMakeAppointmentController::class, 'destroy'])->name('appointment.destroy');
});

Route::get('/', [FrontedController::class, 'index']);
Route::get('doi-ngu-chuyen-gia', [FrontedController::class, 'listDoctor']);
Route::get('doi-ngu-chuyen-gia/{slug}', [FrontedController::class, 'doctor']);
Route::get('dat-lich-kham', [FrontedController::class, 'book']);
Route::get('tin-tuc-tong-hop', [FrontedController::class, 'newsSummary']);
Route::get('{slug}', [FrontedController::class, 'newsList']);
Route::get('tin-tuc/{slug_id}', [FrontedController::class, 'newsDetail']);