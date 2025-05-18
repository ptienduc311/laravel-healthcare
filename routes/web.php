<?php

use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDoctorController;
use App\Http\Controllers\Admin\AdminMakeAppointmentController;
use App\Http\Controllers\Admin\AdminMedicalSpecialtyController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminPostCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ApiController;
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
Route::get('cancel-account/{cancel_token}', [RegisterController::class, 'cancelAccount'])->name('register.cancel');

//Reset Password
Route::get('reset', [LoginController::class, 'reset'])->name('reset.pass');
Route::post('send-link-reset', [LoginController::class, 'sendLinkResetEmail'])->name('reset.send_code');
Route::get('new-pass/{reset_token}', [LoginController::class, 'newPass'])->name('new.pass');
Route::post('new-pass/{reset_token}', [LoginController::class, 'updatePass'])->name('update.pass');

Route::group(['middleware' => ['auth', 'CheckActiveAccount', 'checkRole:admin,doctor,quan-ly-bai-viet,demo-quan-ly-bai-viet'], 'prefix' => 'admin'], function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [AdminController::class, 'profile_update'])->name('admin.profile_update');
    Route::get('/site', [AdminController::class, 'site'])->name('admin.site')->middleware('can:site.edit');
    Route::post('/site/update', [AdminController::class, 'site_update'])->name('admin.site_update')->middleware('can:site.edit');
    
    //API
    Route::get('/api-get-doctors', [AdminDoctorController::class, 'getDoctors']);
    Route::get('/api-get-doctors-connect', [AdminDoctorController::class, 'getDoctorsConnect']);
    Route::get('/show-profile-doctor', [AdminDoctorController::class, 'showProfile'])->name('doctor.show-profile');
    Route::post('/api/check-doctor-appointments', [AdminMakeAppointmentController::class, 'checkAppointment']);
    Route::post('/appointment/confirm-remove', [AdminMakeAppointmentController::class, 'confirmRemove'])->name('appointment.confirm-remove');
    Route::post('/appointment/confirm-delete', [AdminMakeAppointmentController::class, 'confirmDelete'])->name('appointment.confirm-delete');

    //PostCategory
    Route::group(['prefix' => 'post/cat', 'as' => 'post_category.'], function() {
        Route::get('/', [AdminPostCategoryController::class, 'index'])->name('index')->middleware('can:post_category.index');
        Route::get('/add', [AdminPostCategoryController::class, 'create'])->name('add')->middleware('can:post_category.add');
        Route::post('/store', [AdminPostCategoryController::class, 'store'])->name('store')->middleware('can:post_category.add');
        Route::get('/edit/{id}', [AdminPostCategoryController::class, 'edit'])->name('edit')->middleware('can:post_category.edit');
        Route::post('/update/{id}', [AdminPostCategoryController::class, 'update'])->name('update')->middleware('can:post_category.edit');
        Route::get('/destroy/{id}', [AdminPostCategoryController::class, 'destroy'])->name('destroy')->middleware('can:post_category.destroy');
    });
    
    //Post
    Route::group(['prefix' => 'post', 'as' => 'post.'], function() {
        Route::get('/', [AdminPostController::class, 'index'])->name('index')->middleware('can:post.index');
        Route::get('/add', [AdminPostController::class, 'create'])->name('add')->middleware('can:post.add');
        Route::post('/store', [AdminPostController::class, 'store'])->name('store')->middleware('can:post.add');
        Route::get('/edit/{id}', [AdminPostController::class, 'edit'])->name('edit')->middleware('can:post.edit');
        Route::post('/update/{id}', [AdminPostController::class, 'update'])->name('update')->middleware('can:post.edit');
        Route::get('/destroy/{id}', [AdminPostController::class, 'destroy'])->name('destroy')->middleware('can:post.destroy');
    });
   
    //Medical specialty
    Route::group(['prefix' => 'medical-specialty', 'as' => 'medical-specialty.'], function() {
        Route::get('/', [AdminMedicalSpecialtyController::class, 'index'])->name('index')->middleware('can:medical-specialty.index');
        Route::get('/add', [AdminMedicalSpecialtyController::class, 'create'])->name('add')->middleware('can:medical-specialty.add');
        Route::post('/store', [AdminMedicalSpecialtyController::class, 'store'])->name('store')->middleware('can:medical-specialty.add');
        Route::get('/edit/{id}', [AdminMedicalSpecialtyController::class, 'edit'])->name('edit')->middleware('can:medical-specialty.edit');
        Route::post('/update/{id}', [AdminMedicalSpecialtyController::class, 'update'])->name('update')->middleware('can:medical-specialty.edit');
        Route::get('/destroy/{id}', [AdminMedicalSpecialtyController::class, 'destroy'])->name('destroy')->middleware('can:medical-specialty.destroy');  
        Route::get('/info-page', [AdminMedicalSpecialtyController::class, 'info_page'])->name('info-page')->middleware('can:medical-specialty.info-page');
        Route::post('/info-page-handle', [AdminMedicalSpecialtyController::class, 'info_page_handle'])->name('info-page-handle')->middleware('can:medical-specialty.info-page');
        Route::post('/select-service-handle', [AdminMedicalSpecialtyController::class, 'select_service_handle'])->name('select-service-handle')->middleware('can:medical-specialty.info-page');
        Route::post('/search', [AdminMedicalSpecialtyController::class, 'search'])->name('search')->middleware('can:medical-specialty.info-page');
    });
   
    //Upload image
    Route::post('/upload-image', [UploadController::class, 'upload']);

    //Doctor
    Route::group(['prefix' => 'doctor', 'as' => 'doctor.'], function() {
        Route::get('/', [AdminDoctorController::class, 'index'])->name('index')->middleware('can:doctor.index');
        Route::get('/add', [AdminDoctorController::class, 'create'])->name('add')->middleware('can:doctor.add');
        Route::post('/store', [AdminDoctorController::class, 'store'])->name('store')->middleware('can:doctor.add');
        Route::get('/edit/{id}', [AdminDoctorController::class, 'edit'])->name('edit')->middleware('can:doctor.edit');
        Route::post('/update/{id}', [AdminDoctorController::class, 'update'])->name('update')->middleware('can:doctor.edit');
        Route::get('/destroy/{id}', [AdminDoctorController::class, 'destroy'])->name('destroy')->middleware('can:doctor.destroy');

        Route::get('/profile-doctor/{doctorId?}', [AdminDoctorController::class, 'show'])->name('profile-doctor')->middleware('can:doctor.profile');
    });
   
    //Appointment
    Route::group(['prefix' => 'appointment', 'as' => 'appointment.'], function() {
        Route::get('/', [AdminMakeAppointmentController::class, 'index'])->name('index')->middleware('can:appointment.index');
        Route::get('/add/{doctorId?}', [AdminMakeAppointmentController::class, 'create'])->name('add')->middleware('can:appointment.add');
        Route::post('/store/{doctorId}', [AdminMakeAppointmentController::class, 'store'])->name('store')->middleware('can:appointment.add');
        Route::get('/edit/{doctorId}/{date}', [AdminMakeAppointmentController::class, 'edit'])->name('edit')->middleware('can:appointment.edit');
        Route::post('/update/{doctorId}/{date}', [AdminMakeAppointmentController::class, 'update'])->name('update')->middleware('can:appointment.edit');
        Route::get('/destroy/{doctorId}/{date}', [AdminMakeAppointmentController::class, 'destroy'])->name('destroy')->middleware('can:appointment.destroy');
    });
   
    //Permission
    Route::group(['prefix' => 'permission', 'as' => 'permission.'], function() {
        // Route::get('/', [AdminPermissionController::class, 'index'])->name('index')->middleware('can:permission.index');
        Route::get('/add', [AdminPermissionController::class, 'create'])->name('add')->middleware('can:permission.add');
        Route::post('/store', [AdminPermissionController::class, 'store'])->name('store')->middleware('can:permission.add');
        Route::get('/edit/{id}', [AdminPermissionController::class, 'edit'])->name('edit')->middleware('can:permission.edit');
        Route::post('/update/{id}', [AdminPermissionController::class, 'update'])->name('update')->middleware('can:permission.edit');
        Route::get('/destroy/{id}', [AdminPermissionController::class, 'destroy'])->name('destroy')->middleware('can:permission.destroy');
    });
   
    //Role
    Route::group(['prefix' => 'role', 'as' => 'role.'], function() {
        Route::get('/', [AdminRoleController::class, 'index'])->name('index')->middleware('can:role.index');
        // Route::get('/action', [AdminRoleController::class, 'action'])->name('action')->middleware('can:role.action');
        Route::get('/add', [AdminRoleController::class, 'create'])->name('add')->middleware('can:role.add');
        Route::post('/store', [AdminRoleController::class, 'store'])->name('store')->middleware('can:role.add');
        Route::get('/edit/{role}', [AdminRoleController::class, 'edit'])->name('edit')->middleware('can:role.edit');
        Route::post('/update/{role}', [AdminRoleController::class, 'update'])->name('update')->middleware('can:role.edit');
        Route::get('/destroy/{role}', [AdminRoleController::class, 'destroy'])->name('destroy')->middleware('can:role.destroy');
    });
   
    //User
    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
        Route::get('/', [AdminUserController::class, 'index'])->name('index')->middleware('can:user.index');
        // Route::get('/action', [AdminUserController::class, 'action'])->name('action')->middleware('can:user.action');
        Route::get('/add', [AdminUserController::class, 'create'])->name('add')->middleware('can:user.add');
        Route::post('/store', [AdminUserController::class, 'store'])->name('store')->middleware('can:user.add');
        Route::get('/edit/{user}', [AdminUserController::class, 'edit'])->name('edit')->middleware('can:user.edit');
        Route::post('/update/{user}', [AdminUserController::class, 'update'])->name('update')->middleware('can:user.edit');
        Route::get('/destroy/{user}', [AdminUserController::class, 'destroy'])->name('destroy')->middleware('can:user.destroy');

        Route::get('/status/{userId}/{statusCode} ', [AdminUserController::class, 'updateStatus'])->name('status-update')->middleware('can:user.edit');
    });
   
    //Book
    Route::group(['prefix' => 'book', 'as' => 'book.'], function() {
        Route::get('/', [AdminBookController::class, 'index'])->name('index')->middleware('can:book.index');
        // Route::get('/add', [AdminBookController::class, 'create'])->name('add')->middleware('can:book.show');
        // Route::post('/store', [AdminBookController::class, 'store'])->name('store')->middleware('can:book.show');
        Route::get('/show/{book}', [AdminBookController::class, 'show'])->name('show')->middleware('can:book.show');
        Route::post('/update/{book}', [AdminBookController::class, 'update'])->name('update')->middleware('can:book.show');
        Route::get('/start-examination/{book}', [AdminBookController::class, 'startExamination'])->name('start_examination')->middleware('can:book.show');
        
        Route::get('/search-doctor', [AdminBookController::class, 'searchDoctor'])->middleware('can:book.show');
        Route::post('/cancel-appointment', [AdminBookController::class, 'cancelAppointment'])->name('cancel')->middleware('can:book.show');
    });
});

//API
Route::get('api-get-provinces', [ApiController::class, 'getProvince']);
Route::get('api-get-districts', [ApiController::class, 'getDistrict']);
Route::get('api-get-wards', [ApiController::class, 'getWard']);
Route::get('api-get-available-times', [ApiController::class, 'getAvailabelTimes']);
Route::post('api-save-book', [ApiController::class, 'saveBook']);
Route::get('confirm-book/{code}', [ApiController::class, 'confirmBook'])->name('book.confirm');
Route::get('api-get-book-appointment', [ApiController::class, 'getBookAppointment']);
Route::get('api-get-doctors', [ApiController::class, 'getDoctors']);

Route::get('tim-kiem-bac-si', [FrontedController::class, 'searchDoctor']);
Route::get('tim-kiem-bai-viet', [FrontedController::class, 'searchPost']);

Route::get('/', [FrontedController::class, 'index'])->name('home');
Route::get('gioi-thieu', [FrontedController::class, 'introduce']);

Route::get('doi-ngu-chuyen-gia', [FrontedController::class, 'listDoctor']);
Route::get('doi-ngu-chuyen-gia/{slug}', [FrontedController::class, 'doctor']);

Route::get('dat-lich-kham', [FrontedController::class, 'book']);
Route::get('tra-cuu-lich-hen', [FrontedController::class, 'lookAppointment']);

Route::get('chuyen-khoa', [FrontedController::class, 'specialty']);
Route::get('chuyen-khoa/{slug}', [FrontedController::class, 'specialtyPage']);

Route::get('tin-tuc-tong-hop', [FrontedController::class, 'newsSummary']);
Route::get('tin-tuc/{slug_id}', [FrontedController::class, 'newsDetail']);
Route::get('{slug}', [FrontedController::class, 'newsList']);
