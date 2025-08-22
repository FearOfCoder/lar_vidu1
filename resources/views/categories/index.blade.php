@extends('layouts.app')
@section('title','Categories')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Categories</h3>
  @auth
    @if(auth()->user()->role==='admin')
      <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Create</a>
    @endif
  @endauth
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<table class="table table-bordered">
  <thead><tr><th>#</th><th>Name</th><th width="180">Action</th></tr></thead>
  <tbody>
    @forelse($categories as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td><a href="{{ route('categories.show',$c) }}">{{ $c->name }}</a></td>
        <td>
          @auth
          
         @if(auth()->user()->role==='admin')
  <a class="btn btn-sm btn-warning" href="{{ route('admin.categories.edit',$c) }}">Edit</a>
  <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy',$c) }}" onsubmit="return confirm('Delete?')">
    @csrf @method('DELETE')
    <button class="btn btn-sm btn-danger">Delete</button>
  </form>
@endif
          @endauth
        </td>
      </tr>
    @empty
      <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
    @endforelse
  </tbody>
</table>

{{ $categories->links() }}
@endsection
