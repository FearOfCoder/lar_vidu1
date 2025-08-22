@extends('layouts.app')

@section('title','Đăng nhập')

@section('content')
<style>
  .auth-shell{
    max-width: 520px; margin: 24px auto; 
  }
  .auth-head{ margin-bottom: 14px }
  .auth-sub{ color: var(--muted) }
  .auth-actions{ display:flex; gap:10px; align-items:center; justify-content:space-between; flex-wrap:wrap }
</style>

<div class="auth-shell">
  <div class="card card-pad">
    <div class="auth-head">
      <div class="title">Chào mừng trở lại 👋</div>
      <div class="auth-sub">Đăng nhập để mua sắm và quản lý đơn hàng</div>
    </div>

    {{-- Tóm tắt lỗi --}}
    @if ($errors->any())
      <div class="card card-pad mb-3" style="border-color:#ffdbdb;background:#fff5f5">
        <div class="muted" style="color:var(--danger);font-weight:700;margin-bottom:6px">Có lỗi xảy ra</div>
        <ul style="margin:0 0 0 18px">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="form" novalidate>
      @csrf

      <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" class="input" required value="{{ old('email') }}">
        @error('email') <div class="error">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <label for="password">Mật khẩu</label>
        <div style="position:relative">
          <input id="password" type="password" name="password" class="input" required>
          <button type="button" aria-label="Hiện/ẩn mật khẩu"
                  onclick="const i=document.getElementById('password'); i.type = i.type==='password'?'text':'password';"
                  class="btn btn-ghost" style="position:absolute;right:6px;top:6px;padding:8px 10px">
            <i class="ri-eye-line"></i>
          </button>
        </div>
        @error('password') <div class="error">{{ $message }}</div> @enderror
      </div>

      <div class="row" style="justify-content:space-between;align-items:center">
        <label style="display:flex;align-items:center;gap:8px">
          <input type="checkbox" name="remember"> Ghi nhớ
        </label>
        {{-- <a href="{{ route('password.request') }}" class="link">Quên mật khẩu?</a> --}}
      </div>

      <div class="auth-actions mt-3">
        <button class="btn btn-brand grow">Đăng nhập</button>
        <a href="{{ route('register.show') }}" class="btn btn-ghost">Chưa có tài khoản? Đăng ký</a>
      </div>
    </form>
  </div>
</div>
@endsection
