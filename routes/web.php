<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterLoginCheckController;
use Illuminate\Http\Request;

// ================= Home Routes =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// ================= Auth Routes =================
Route::get('/login', [RegisterLoginCheckController::class, 'login'])->name('login'); 
Route::post('/login_check', [RegisterLoginCheckController::class, 'login_check'])->name('login_check');
Route::post('/logout', function(Request $request) {
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

// ================= Buyer / User =================
Route::get('/user/dashboard', function () {
    return view('dashboards.user');
})->middleware('check.session:customer')->name('user.dashboard');

// ================= Farmer =================
Route::get('/farmer/dashboard', function () {
    return view('dashboards.farmer');
})->middleware('check.session:farmer')->name('farmer.dashboard');

// ================= Admin =================
// Adjust according to your admin auth
Route::get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->name('admin.dashboard');
