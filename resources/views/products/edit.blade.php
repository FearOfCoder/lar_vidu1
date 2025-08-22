@extends('layouts.app')
@section('title','Edit Product')
@section('content')
<h3>Edit Product</h3>
<form method="POST" action="{{ route('admin.products.update',$product) }}" enctype="multipart/form-data">
  @csrf @method('PUT')

  @csrf @method('PUT')
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Name</label>
      <input name="name" class="form-control" value="{{ old('name',$product->name) }}" required>
      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Price</label>
      <input name="price" type="number" step="0.01" min="0" class="form-control" value="{{ old('price',$product->price) }}" required>
      @error('price') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-3 mb-3">
      <label class="form-label">Quantity</label>
      <input name="quantity" type="number" min="0" class="form-control" value="{{ old('quantity',$product->quantity) }}" required>
      @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id',$product->category_id)==$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Image (choose to replace)</label>
      <input name="image" type="file" class="form-control">
      @if($product->image)
        <div class="mt-2"><img src="{{ asset('storage/'.$product->image) }}" style="height:60px;object-fit:cover"></div>
      @endif
      @error('image') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-12 mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description',$product->description) }}</textarea>
    </div>
    <div class="col-12 mb-3">
      <label class="form-label">Features</label>
      <textarea name="features" class="form-control" rows="2">{{ old('features',$product->features) }}</textarea>
    </div>
  </div>
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
