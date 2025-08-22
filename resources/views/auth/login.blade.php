@extends('layouts.app')

@section('title','Đăng nhập')

@section('content')
<h2>Đăng nhập</h2>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="/login" method="POST">
  @csrf

  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label>Mật khẩu</label>
    <input type="password" name="password" class="form-control" required>
    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-check mb-3">
    <input type="checkbox" name="remember" class="form-check-input" id="remember">
    <label for="remember" class="form-check-label">Ghi nhớ</label>
  </div>

  <button class="btn btn-primary">Đăng nhập</button>
</form>
@endsection
