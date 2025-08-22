@extends('layouts.app')
@section('title','Create Category')
@section('content')
<h3>Create Category</h3>
<form method="POST" action="{{ route('admin.categories.store') }}">@csrf

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" class="form-control" value="{{ old('name') }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
  </div>
  <button class="btn btn-primary">Save</button>
  <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
