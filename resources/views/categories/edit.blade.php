@extends('layouts.app')
@section('title','Edit Category')
@section('content')
<h3>Edit Category</h3>
<form method="POST" action="{{ route('admin.categories.update',$category) }}">@csrf @method('PUT')

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
