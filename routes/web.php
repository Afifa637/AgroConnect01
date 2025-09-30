<?php

require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

// ================= Buyer / User Dashboard =================
Route::get('/user/dashboard', function () {
    return view('dashboards.user');
})->middleware(['auth', 'verified', 'check.session:customer'])->name('user.dashboard');

// ================= Farmer Dashboard =================
Route::get('/farmer/dashboard', function () {
    return view('dashboards.farmer');
})->middleware(['auth', 'verified','check.session:farmer'])->name('farmer.dashboard');

// ================= Admin Dashboard =================
Route::get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->middleware(['auth', 'verified'])->name('admin.dashboard');
