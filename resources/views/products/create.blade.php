@extends('layouts.app')
@section('title','Create Product')
@section('content')
<h3>Create Product</h3>
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">@csrf

  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Name</label>
      <input name="name" class="form-control" value="{{ old('name') }}" required>
      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Price</label>
      <input name="price" type="number" step="0.01" min="0" class="form-control" value="{{ old('price') }}" required>
      @error('price') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Quantity</label>
      <input name="quantity" type="number" min="0" class="form-control" value="{{ old('quantity',0) }}" required>
      @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        <option value="">-- Select --</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Image</label>
      <input name="image" type="file" class="form-control">
      @error('image') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-12 mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>
    <div class="col-12 mb-3">
      <label class="form-label">Features</label>
      <textarea name="features" class="form-control" rows="2">{{ old('features') }}</textarea>
    </div>
  </div>
  <button class="btn btn-success">Save</button>
  <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
