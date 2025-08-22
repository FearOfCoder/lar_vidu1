@extends('layouts.app')
@section('title','Quản lý danh mục')

@section('content')
  <div class="header">
    <div>
      <div class="title">Quản lý danh mục</div>
      <div class="muted">Tổ chức danh mục sản phẩm</div>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-brand"><i class="ri-folder-add-line"></i> Thêm danh mục</a>
  </div>

  <div class="card card-pad">
    @if(session('success')) <div class="mb-3" style="color:var(--ok);font-weight:700">{{ session('success') }}</div> @endif

    <div style="overflow:auto">
      <table class="table">
        <thead>
          <tr>
            <th width="90">ID</th>
            <th>Tên danh mục</th>
            <th width="200">Ngày tạo</th>
            <th width="220" class="right">Hành động</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $c)
          <tr>
            <td>#{{ $c->id }}</td>
            <td class="fw-600">{{ $c->name }}</td>
            <td>{{ optional($c->created_at)->format('d/m/Y') }}</td>
            <td class="right">
              <a href="{{ route('admin.categories.edit',$c) }}" class="btn btn-ghost">Sửa</a>
              <form action="{{ route('admin.categories.destroy',$c) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá danh mục này?')">
                @csrf @method('DELETE')
                <button class="btn btn-ghost" style="color:var(--danger);border-color:#ffdbdb">Xoá</button>
              </form>
            </td>
          </tr>
          @empty
            <tr><td colspan="4" class="center muted">Chưa có danh mục</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
  </div>
@endsection
