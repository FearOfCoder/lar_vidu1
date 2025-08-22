@extends('layouts.app')
@section('title','Xác thực Email')

@section('content')
<div class="card card-pad center" style="max-width:560px;margin:24px auto">
  <div class="title mb-2">Vui lòng xác thực email</div>
  <p>Một email xác thực đã được gửi tới <strong>{{ auth()->user()->email }}</strong>.</p>
  <p>Hãy mở email và bấm vào liên kết xác thực để tiếp tục.</p>

  @if (session('success'))
    <div class="mt-3" style="color:var(--ok);font-weight:700">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
    @csrf
    <button class="btn btn-brand"><i class="ri-mail-send-line"></i> Gửi lại link xác thực</button>
  </form>
</div>
@endsection
