@extends('layouts.app')
@section('title','Products')
@php use Illuminate\Support\Str; @endphp
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Products</h3>
  @auth
    @if(auth()->user()->role==='admin')
     <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Create</a>
    @endif
  @endauth
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<table class="table table-bordered align-middle">
  <thead>
    <tr>
      <th>#</th><th>Name</th><th>Category</th><th>Qty</th><th>Price</th><th>Description</th><th>Image</th><th width="200">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($products as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td><a href="{{ route('products.show',$p) }}">{{ $p->name }}</a></td>
        <td>{{ $p->category->name ?? '—' }}</td>
        <td>{{ $p->quantity }}</td>
        <td>{{ number_format($p->price,0) }} đ</td>
        <td>{{ Str::limit($p->description,60) }}</td>
      <td>
  <img src="{{ $p->image_url }}" alt="{{ $p->name }}"
       style="height:64px;width:96px;object-fit:cover;border-radius:10px;border:1px solid var(--line)">
</td>

        <td>
          @auth
        @if(auth()->user()->role==='admin')
  <a class="btn btn-sm btn-warning" href="{{ route('admin.products.edit',$p) }}">Edit</a>
  <form class="d-inline" method="POST" action="{{ route('admin.products.destroy',$p) }}" onsubmit="return confirm('Delete?')">
    @csrf @method('DELETE')
    <button class="btn btn-sm btn-danger">Delete</button>
  </form>
@endif
          @endauth
        </td>
      </tr>
    @empty
      <tr><td colspan="8" class="text-center text-muted">No data</td></tr>
    @endforelse
  </tbody>
</table>

{{ $products->links() }}
@endsection
