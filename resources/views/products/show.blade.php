@extends('layouts.app')
@section('title','Product Detail')
@section('content')
<h3>Product Detail</h3>
<p><strong>ID:</strong> {{ $product->id }}</p>
<p><strong>Name:</strong> {{ $product->name }}</p>
<p><strong>Category:</strong> {{ $product->category->name ?? '—' }}</p>
<p><strong>Price:</strong> {{ number_format($product->price,0) }} đ</p>
<p><strong>Quantity:</strong> {{ $product->quantity }}</p>
@if($product->image)
  <p><img src="{{ $product->image_url }}" alt="{{ $product->name }}"
     style="width:100%;max-width:560px;height:340px;object-fit:cover;border-radius:16px;border:1px solid var(--line)">
</p>
@endif
<p><strong>Description:</strong><br>{{ $product->description }}</p>
<p><strong>Features:</strong><br>{{ $product->features }}</p>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
@endsection
