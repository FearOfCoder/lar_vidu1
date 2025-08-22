@extends('layouts.app')

@section('title','Đăng ký')

@section('content')
<h2>Đăng ký</h2>

{{-- Thông báo thành công (khi chuyển từ nơi khác về) --}}
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- TÓM TẮT LỖI --}}
@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('register.perform') }}" method="POST" novalidate>
  @csrf
  <div class="form-group mb-3">
    <label>Họ tên</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="form-group mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="form-group mb-3">
    <label>Mật khẩu (≥ 6 ký tự)</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="form-group mb-4">
    <label>Nhập lại mật khẩu</label>
    <input type="password" name="password_confirmation" class="form-control" required>
  </div>

  <button class="btn btn-success">Đăng ký</button>
  <a href="{{ route('login') }}" class="btn btn-link">Đăng nhập</a>
</form>
@endsection
