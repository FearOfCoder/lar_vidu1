<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', fn () => view('welcome'));

// guest
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

// logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// PUBLIC: chỉ cho xem PRODUCTS (user chỉ xem)
Route::resource('products', ProductController::class)->only(['index','show']);

// ADMIN: có prefix + name, quản trị FULL products & categories
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
 Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
