@extends('layouts.app')

@section('title','Trang chủ')

@section('content')
  @auth
    @if(auth()->user()->role === 'admin')
      {{-- ADMIN DASHBOARD --}}
      <div class="row" style="display:grid;grid-template-columns:repeat(12,1fr);gap:16px">
        {{-- Stats cards --}}
        <div class="card card-pad" style="grid-column:span 6">
          <div class="title mb-2">Tổng quan</div>
          <div class="row">
            <div class="card card-pad grow" style="border-color:#e3e9ff">
              <div class="muted mb-1">Sản phẩm</div>
              <div style="font-size:26px;font-weight:800;color:var(--brand)">{{ $stats['products'] ?? 0 }}</div>
            </div>
            <div class="card card-pad grow" style="border-color:#dff3f6">
              <div class="muted mb-1">Danh mục</div>
              <div style="font-size:26px;font-weight:800;color:var(--brand-2)">{{ $stats['categories'] ?? 0 }}</div>
            </div>
          </div>
          <div class="mt-3 row">
            <a href="{{ route('admin.products.index') }}" class="btn btn-brand">Quản lý sản phẩm</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Quản lý danh mục</a>
          </div>
        </div>

        {{-- Quick actions --}}
        <div class="card card-pad" style="grid-column:span 6">
          <div class="title mb-2">Thao tác nhanh</div>
          <div class="row">
            <a href="{{ route('admin.products.create') }}" class="btn btn-ghost grow"><i class="ri-add-circle-line"></i> Thêm sản phẩm</a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-ghost grow"><i class="ri-folder-add-line"></i> Thêm danh mục</a>
          </div>
          <p class="muted mt-3">Mẹo: dùng menu trên thanh điều hướng để đi nhanh đến các trang quản trị.</p>
        </div>

        {{-- Recent products --}}
        <div class="card card-pad" style="grid-column:span 12">
          <div class="header">
            <div>
              <div class="title">Sản phẩm mới thêm</div>
              <div class="muted">8 mục gần nhất</div>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Xem tất cả</a>
          </div>

          @if(!empty($recentProducts) && $recentProducts->count())
            <div class="grid">
              @foreach($recentProducts as $p)
                <article class="product">
                  <div class="row">
                    <span class="chip">{{ $p->category->name ?? '—' }}</span>
                    <span class="right price">{{ number_format($p->price,0,',','.') }} đ</span>
                  </div>
                  <strong style="font-size:17px">{{ $p->name }}</strong>
                  <p class="muted" style="margin:0 0 10px 0">{{ \Illuminate\Support\Str::limit($p->description, 80) }}</p>
                  <div class="row mt-2">
                    <a href="{{ route('products.show',$p) }}" class="btn btn-ghost">Xem</a>
                    <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-ghost">Sửa</a>
                    <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="right" onsubmit="return confirm('Xoá sản phẩm này?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-ghost" style="color:var(--danger);border-color:#ffdbdb">Xoá</button>
                    </form>
                  </div>
                </article>
              @endforeach
            </div>
          @else
            <div class="card card-pad">Chưa có dữ liệu.</div>
          @endif
        </div>
      </div>
    @else
      {{-- USER / KHÁCH: HIỆN LUÔN LIST SẢN PHẨM --}}
      <div class="header">
        <div>
          <div class="title">Sản phẩm nổi bật</div>
          <div class="muted">Khám phá các sản phẩm mới nhất</div>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-ghost">Xem tất cả</a>
      </div>

      @if(isset($products) && $products->count())
        <div class="grid">
          @foreach($products as $p)
            <article class="product">
              <div class="row">
                <span class="chip">{{ $p->category->name ?? 'Danh mục' }}</span>
                <span class="right price">{{ number_format($p->price,0,',','.') }} đ</span>
              </div>
              <h3 style="margin:6px 0 2px 0; font-size:17px">{{ $p->name }}</h3>
              <p class="muted" style="margin:0 0 10px 0">{{ \Illuminate\Support\Str::limit($p->description, 80) }}</p>
              <a href="{{ route('products.show',$p) }}" class="btn btn-ghost mt-2">Xem chi tiết</a>
            </article>
          @endforeach
        </div>

        <div class="mt-6">
          {{ $products->links() }}
        </div>
      @else
        <div class="card card-pad center">Chưa có sản phẩm.</div>
      @endif
    @endif
  @endauth

  @guest
    {{-- KHÁCH: giống user, nhưng thêm lời mời đăng nhập --}}
    <div class="header">
      <div>
        <div class="title">Sản phẩm mới</div>
        <div class="muted">Đăng nhập để mua sắm và quản lý đơn hàng</div>
      </div>
      <div class="row">
        <a href="{{ route('login') }}" class="btn btn-ghost">Đăng nhập</a>
        <a href="{{ route('register.show') }}" class="btn btn-brand">Đăng ký</a>
      </div>
    </div>

    @if(isset($products) && $products->count())
      <div class="grid">
        @foreach($products as $p)
          <article class="product">
            <div class="row">
              <span class="chip">{{ $p->category->name ?? 'Danh mục' }}</span>
              <span class="right price">{{ number_format($p->price,0,',','.') }} đ</span>
            </div>
            <h3 style="margin:6px 0 2px 0; font-size:17px">{{ $p->name }}</h3>
            <p class="muted" style="margin:0 0 10px 0">{{ \Illuminate\Support\Str::limit($p->description, 80) }}</p>
            <a href="{{ route('products.show',$p) }}" class="btn btn-ghost mt-2">Xem chi tiết</a>
          </article>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $products->links() }}
      </div>
    @else
      <div class="card card-pad center">Chưa có sản phẩm.</div>
    @endif
  @endguest
@endsection
