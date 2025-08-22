@extends('layouts.app')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<style>
  .product-detail{
    max-width: 900px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
  }
  @media (min-width:768px){
    .product-detail{
      grid-template-columns: 1fr 1fr;
      align-items: start;
    }
  }
  .product-image{
    width: 100%;
    aspect-ratio: 4 / 3;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--line);
    background: #f6f8fc;
  }
  .product-image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }
  .product-info .price{
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--brand);
    margin-bottom: 10px;
  }
  .product-info .meta{
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 16px;
  }
  .product-info .meta div{
    font-weight: 600;
  }
  .product-info p{
    margin: 0 0 12px 0;
  }
</style>

<div class="card card-pad">
  <div class="title mb-3">Chi tiết sản phẩm</div>
  <div class="product-detail">
    {{-- Hình ảnh --}}
    <div class="product-image">
      @if($product->image)
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
      @else
        <img src="{{ asset('images/placeholder.png') }}" alt="No image">
      @endif
    </div>

    {{-- Thông tin --}}
    <div class="product-info">
      <h2 style="margin-top:0">{{ $product->name }}</h2>
      <div class="price">{{ number_format($product->price, 0, ',', '.') }} đ</div>

      <div class="meta">
        <div><strong>Mã:</strong> #{{ $product->id }}</div>
        <div><strong>Danh mục:</strong> {{ $product->category->name ?? '—' }}</div>
        <div><strong>Số lượng:</strong> {{ $product->quantity }}</div>
      </div>

      @if($product->description)
        <p><strong>Mô tả:</strong><br>{{ $product->description }}</p>
      @endif

      @if($product->features)
        <p><strong>Đặc điểm:</strong><br>{{ $product->features }}</p>
      @endif

      <div class="mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-ghost">Quay lại</a>
      </div>
    </div>
  </div>
</div>
@endsection
