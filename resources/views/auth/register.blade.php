@extends('layouts.app')

@section('title','Đăng ký')

@section('content')
<style>
  .auth-shell{
    max-width: 620px; margin: 24px auto;
  }
  .auth-head{ margin-bottom: 14px }
  .auth-sub{ color: var(--muted) }
  .grid-2{ display:grid; gap:14px }
  @media (min-width:640px){ .grid-2{ grid-template-columns: 1fr 1fr } }
</style>

<div class="auth-shell">
  <div class="card card-pad">
    <div class="auth-head">
      <div class="title">Tạo tài khoản ✨</div>
      <div class="auth-sub">Gia nhập Mỹ phẩm Anh Độ để trải nghiệm tốt hơn</div>
    </div>

    {{-- Tóm tắt lỗi --}}
    @if ($errors->any())
      <div class="card card-pad mb-3" style="border-color:#ffdbdb;background:#fff5f5">
        <div class="muted" style="color:var(--danger);font-weight:700;margin-bottom:6px">Vui lòng kiểm tra lại</div>
        <ul style="margin:0 0 0 18px">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.perform') }}" method="POST" class="form" novalidate>
      @csrf

      <div class="grid-2">
        <div class="field">
          <label for="name">Họ tên</label>
          <input id="name" type="text" name="name" class="input" value="{{ old('name') }}" required>
          @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" class="input" value="{{ old('email') }}" required>
          @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="grid-2">
        <div class="field">
          <label for="password">Mật khẩu (≥ 6 ký tự)</label>
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

        <div class="field">
          <label for="password_confirmation">Nhập lại mật khẩu</label>
          <input id="password_confirmation" type="password" name="password_confirmation" class="input" required>
        </div>
      </div>

      <div class="row mt-2" style="align-items:center;justify-content:space-between">
        <div class="help">Bằng việc đăng ký, bạn đồng ý với điều khoản sử dụng.</div>
        {{-- <label style="display:flex;align-items:center;gap:8px"><input type="checkbox" required> Đồng ý điều khoản</label> --}}
      </div>

      <div class="row mt-3" style="justify-content:space-between;gap:10px">
        <button class="btn btn-brand grow">Tạo tài khoản</button>
        <a href="{{ route('login') }}" class="btn btn-ghost">Đã có tài khoản? Đăng nhập</a>
      </div>
    </form>
  </div>
</div>
@endsection
