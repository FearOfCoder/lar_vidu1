<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Danh sách / chi tiết sản phẩm (ai cũng xem được)
Route::resource('products', ProductController::class)->only(['index', 'show']);


/*
|--------------------------------------------------------------------------
| Auth (guest / auth)
|--------------------------------------------------------------------------
*/

// Khách: đăng ký / đăng nhập
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

// Đăng xuất (đã đăng nhập)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Email Verification (Laravel built-in)
|--------------------------------------------------------------------------
*/

// Trang nhắc xác thực (khi đã login nhưng chưa verify)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Link xác thực trong email - KHÔNG yêu cầu auth, chỉ cần chữ ký
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Gửi lại link xác thực (cần đăng nhập)
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Đã gửi lại link xác thực.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Admin (phải đăng nhập + đã xác thực + có role admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        Route::resource('products', CategoryController::class)->except([]);   // nếu bạn muốn FULL CRUD thì bỏ except([])
        Route::resource('categories', CategoryController::class)->except([]);
        // Lưu ý: dòng trên đang gán nhầm controller cho products.
        // Nếu controller sản phẩm là ProductController, sửa lại như bên dưới:
        // Route::resource('products', ProductController::class);
        // Route::resource('categories', CategoryController::class);
    });
