<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
