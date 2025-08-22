<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // đánh dấu đã xác thực
    return redirect()->route('home')->with('success', 'Email đã được xác thực!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Đã gửi lại link xác thực.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');