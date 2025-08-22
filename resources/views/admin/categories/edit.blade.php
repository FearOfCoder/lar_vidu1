@extends('layouts.app')
@section('title','Sửa danh mục')

@section('content')
<h1>Sửa danh mục</h1>

<form method="POST" action="{{ route('admin.categories.update',$category) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Tên danh mục</label>
    <input name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
  <button class="btn btn-primary">Cập nhật</button>
  <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
