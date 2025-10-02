<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\FarmCropController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterLoginCheckController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// ================= Email Verification =================

// Show verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Handle verification link click
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home'); // Redirect after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ================= Home Routes =================
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/services', 'services')->name('services');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/news_info', 'news_info')->name('news_info');

    // Categories & Crops
    Route::get('/categories/{crop_type}', 'Categories')->name('Categories');
    Route::get('/sessions/categories/{crop_type}/{crop_session}', 'Session_Categories')->name('Session_Categories');
    Route::get('/crop_details/{id}', 'crop_details')->name('crop_details');

    // Search
    Route::get('/search', 'search')->name('search');

    // Contact form submit
    Route::post('/contact/submit', 'contactSubmit')->name('contact.submit');
});

// ================= Auth Routes =================
Route::get('/login', [RegisterLoginCheckController::class, 'login'])->name('login');
Route::post('/login_check', [RegisterLoginCheckController::class, 'login_check'])->name('login_check');
Route::post('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/login');
})->name('logout');

// Register / Signup
Route::get('/signup', [RegisterLoginCheckController::class, 'signup'])->name('signup');
Route::post('/registerSave', [RegisterLoginCheckController::class, 'registerSave'])->name('registerSave');

// Password Reset
Route::post('/pw_change_link', [RegisterLoginCheckController::class, 'pw_change_link'])->name('pw_change_link');
Route::get('/pw_change/{role}/{email}', [RegisterLoginCheckController::class, 'pw_change'])->name('pw_change');
Route::post('/pass_change_save/{role}/{email}', [RegisterLoginCheckController::class, 'pass_change_save'])->name('pass_change_save');

// ================= Buyer / User Dashboard =================
Route::get('/user/dashboard', function () {
    return view('dashboards.user');
})->middleware(['auth', 'verified', 'check.session:customer'])->name('user.dashboard');

// ================= Farmer Dashboard =================
Route::get('/farmer/dashboard', function () {
    return view('dashboards.farmer');
})->middleware(['auth', 'verified', 'check.session:farmer'])->name('farmer.dashboard');

// ================= Admin Dashboard =================
Route::get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

// ================= Farmer Routes =================
//Route::middleware('f_check')->group(function () {
    // Farmer Home & Profile
    Route::controller(FarmerController::class)->group(function () {
        Route::get('/farmer/home/page', 'f_home')->name('f_home');
        Route::get('/farmer/search', [FarmerController::class, 'searchCrops'])->name('farmer.search');
        Route::get('/farmer/bid/messages', 'farm_bid_messages')->name('farm_bid_messages');
        Route::get('/farmer/confirm/form/{id}', 'confirm_form')->name('confirm_form');
        Route::get('/confirm/crops', 'confirm_crops')->name('confirm_crops');
        Route::get('/confirm/delete/{id}', 'delete_confirm')->name('delete_confirm');
        Route::get('/farmer/profile/{f_username}', 'fa_profile')->name('fa_profile');
        Route::post('/farmer/profile/update', [FarmerController::class, 'updateProfile'])->name('update_farmer');
        Route::get('/farmer', 'f_settings')->name('f_settings');
        Route::get('/customer/details/{username}', 'customer_profile')->name('customer_profile');
    });

    // Crops
    Route::controller(FarmCropController::class)->group(function () {
        Route::get('/farmer/crops/import', 'create')->name('crop_import');
        Route::post('/farmer/crops/store', 'store')->name('crop_store');
        Route::get('/farmer/crops/manage', 'index')->name('crop_manage');
        Route::get('/farmer/crops/edit/{id}', 'edit')->name('crop_edit');
        Route::put('/farmer/crops/update/{id}', 'update')->name('crop_update');
        Route::get('/farmer/crops/delete/{id}', 'destroy')->name('crop_delete');
        Route::get('/farmer/crops/status/{id}', 'toggleStatus')->name('crop_status');
    });

    // Orders
    Route::controller(OrderController::class)->group(function () {
        Route::get('/farmer/orders', 'farmOrderMessages')->name('farmer_orders');
        Route::get('/customer/orders', 'custOrderMessages')->name('customer_orders');
        Route::get('/order/payment/{id}', 'paymentForm')->name('order_payment_form');
        Route::post('/order/manual/payment', 'manuallyPayment')->name('order_manual_payment');
    });
//});
