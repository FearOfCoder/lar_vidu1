<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }

  public function register(Request $request) {
    $data = $request->validate([
        'name'                  => ['required','string','max:255'],
        'email'                 => ['required','email','max:255','unique:users,email'],
        'password'              => ['required','string','min:6','confirmed'],
    ]);

    // Tạo user mới
    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'role'     => 'customer',
    ]);

    // Gửi email xác thực
    $user->sendEmailVerificationNotification();

    return redirect('/login')->with('success','Đăng ký thành công! Mời kiểm tra email để xác thực.');
}

    public function showLogin() { return view('auth.login'); }

  public function login(Request $request) {
    $request->validate([
        'email'    => ['required','email'],
        'password' => ['required','string'],
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($request->only('email','password'), $remember)) {
        $request->session()->regenerate();

        if (! $request->user()->hasVerifiedEmail()) {
            // (tuỳ chọn) gửi lại link mỗi lần họ đăng nhập mà chưa verify
            $request->user()->sendEmailVerificationNotification();

            return redirect()->route('verification.notice')
                ->with('error','Vui lòng xác thực email. Link đã được gửi vào Mailtrap.');
        }

        return redirect()->intended('/')->with('success','Đăng nhập thành công!');
    }

    return back()
        ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
        ->withInput($request->only('email'));
}
public function verifyEmail(Request $request, $id, $hash)
{
    $user = \App\Models\User::findOrFail($id);

    // Kiểm tra chữ ký email trong link
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Link xác thực không hợp lệ.');
    }

    // Đánh dấu đã xác thực (nếu chưa)
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    // TỰ ĐỘNG ĐĂNG NHẬP user (kể cả trước đó chưa login)
    Auth::login($user);

    // Về trang chủ (hoặc intended)
    return redirect()->intended(route('home'))
        ->with('success', 'Email đã được xác thực! Chào mừng bạn.');
}


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success','Đã đăng xuất.');
    }
}
