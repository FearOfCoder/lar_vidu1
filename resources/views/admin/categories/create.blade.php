@extends('layouts.app')
@section('title','Thêm danh mục')

@section('content')
<h1>Thêm danh mục</h1>

<form method="POST" action="{{ route('admin.categories.store') }}">@csrf
  <div class="mb-3">
    <label class="form-label">Tên danh mục</label>
    <input name="name" class="form-control" value="{{ old('name') }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
  <button class="btn btn-primary">Lưu</button>
  <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
