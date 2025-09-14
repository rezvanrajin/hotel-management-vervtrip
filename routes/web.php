<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RoomController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HoteRoomlController;
use App\Http\Controllers\Backend\BookingRoomController;
use App\Http\Controllers\Backend\LandingPageSetupController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/booking/{room}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('/booking/{booking}/process-payment', [BookingController::class, 'processPayment'])->name('booking.process-payment');
Route::get('/booking/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/booking/{booking}/download', [BookingController::class, 'download'])->name('booking.download');


Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::get('register', 'registration')->name('register');
    Route::get('reset-password', 'forgotPassword');
    Route::any('reset-otp-send', 'resetOtpSend');
    Route::any('change-password', 'otp');
});

// Auth route
Route::post('login-post', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('signup', [LoginController::class, 'signup'])->name('registration.post');
Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::get('contact', [LoginController::class, 'contact'])->name('admin.contact');
Route::get('about', [LoginController::class, 'about'])->name('admin.resource');


// admin route start
Route::get('/admin', function () {
    if (Auth::user()) {
        return redirect()->route('admin.index');
    } else {
        return view('auth.pages.login');
    }
})->name('admin');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    // profile
    Route::get('profile', [LoginController::class, 'adminProfile'])->name('admin.profile');
    Route::post('profile/update', [LoginController::class, 'adminProfileUpdate'])->name('admin.profile.update');
    Route::get('profile/setting', [LoginController::class, 'adminProfileSetting'])->name('admin.profile.setting');
    Route::post('profile/change/password', [LoginController::class, 'adminChangePassword'])->name('admin.change.password');

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('dashboard-get-data', [DashboardController::class, 'getData'])->name('admin.dashboard.get.data');

    // user routes
    Route::group(['prefix' => '/user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::get('/get/list', [UserController::class, 'getList']);
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::any('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::post('/change', [UserController::class, 'changePassword'])->name('admin.user.changepassword');

        Route::get('/{id}', [UserController::class, 'userDetails'])->name('admin.user.details');
        Route::get('/details/get/list', [UserController::class, 'getDetailList']);

    });

    //  role routes
    Route::group(['prefix' => '/role'], function () {
        Route::get('/generate/right/{mdule_name}', [RoleController::class, 'generate'])->name('admin.role.right.generate');

        Route::get('/', [RoleController::class, 'index'])->name('admin.role');
        Route::get('/get/role/list', [RoleController::class, 'getRoleList']);
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::any('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');

        Route::get('/right', [RoleController::class, 'right'])->name('admin.role.right');
        Route::get('/get/right/list', [RoleController::class, 'getRightList']);
        Route::post('/right/store', [RoleController::class, 'rightStore'])->name('admin.role.right.store');
        Route::get('/right/edit/{id}', [RoleController::class, 'editRight'])->name('admin.role.right.edit');
        Route::any('/right/update/{id}', [RoleController::class, 'roleRightUpdate'])->name('admin.role.right.update');
        Route::get('/right/delete/{id}', [RoleController::class, 'rightDelete'])->name('admin.role.right.delete');
    });

    Route::group(['prefix' => '/setting'], function () {
        Route::get('/general', [SettingController::class, 'general'])->name('admin.setting.general');
        Route::get('/static-content', [SettingController::class, 'staticContent'])->name('admin.setting.static.content');
        Route::get('/legal-content', [SettingController::class, 'legalContent'])->name('admin.setting.legal.content');
        Route::post('/update', [SettingController::class, 'update'])->name('admin.setting.update');
        Route::get('/change-language', [SettingController::class, 'changeLanguage'])->name('admin.setting.change.language');

        Route::get('/general/landing/page', [LandingPageSetupController::class, 'general_landing_page'])->name('admin.setting.general.page');
        Route::get('/general/landing/hero/page', [LandingPageSetupController::class, 'hero_setup_section'])->name('admin.setting.hero.section');

    });


    Route::group(['prefix' => '/hotel-room'], function () {
        Route::get('/', [HoteRoomlController::class, 'index'])->name('hotel.room');
        Route::get('/get/list', [HoteRoomlController::class, 'getList']);
        Route::get('/create', [HoteRoomlController::class, 'create'])->name('hotel.room.create');
        Route::post('/store', [HoteRoomlController::class, 'store'])->name('hotel.room.store');
        Route::get('/edit/{id}', [HoteRoomlController::class, 'edit'])->name('hotel.room.edit');
        Route::get('/view/{id}', [HoteRoomlController::class, 'view'])->name('hotel.room.view');
        Route::any('/update/{id}', [HoteRoomlController::class, 'update'])->name('hotel.room.update');
        Route::get('/delete/{id}', [HoteRoomlController::class, 'delete'])->name('hotel.room.delete');


    });

        Route::group(['prefix' => '/booking-room'], function () {
        Route::get('/', [BookingRoomController::class, 'index'])->name('booking.room');
        Route::get('/get/list', [BookingRoomController::class, 'getList']);
        Route::get('/create', [BookingRoomController::class, 'create'])->name('booking.room.create');
        Route::post('/store', [BookingRoomController::class, 'store'])->name('booking.room.store');
        Route::get('/edit/{id}', [BookingRoomController::class, 'edit'])->name('booking.room.edit');
        Route::get('/view/{id}', [BookingRoomController::class, 'view'])->name('booking.room.view');
        Route::put('/update/{id}', [BookingRoomController::class, 'update'])->name('booking.room.update');
        Route::delete('/delete/{id}', [BookingRoomController::class, 'delete'])->name('booking.room.delete');

    });
  

});







