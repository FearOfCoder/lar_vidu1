@extends('layouts.app')
@section('title','Category Detail')
@section('content')
<h3>Category Detail</h3>
<p><strong>ID:</strong> {{ $category->id }}</p>
<p><strong>Name:</strong> {{ $category->name }}</p>
<a class="btn btn-secondary" href="{{ route('categories.index') }}">Back</a>
@endsection
