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
        // 1) validate input
        $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        // 2) attempt login
        $remember = $request->boolean('remember');
        if (Auth::attempt($request->only('email','password'), $remember)) {
        $request->session()->regenerate();
        // ⬇️ sau khi login -> về trang chủ
        return redirect('/')->with('success', 'Đăng nhập thành công!');
    }
        // 3) trả lỗi + giữ lại email
        return back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success','Đã đăng xuất.');
    }
}
