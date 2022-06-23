@extends('admin.master')
@section('title', 'Edit Categories | ' . env('APP_NAME'))
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
        <a class="btn btn-dark" href="{{ route('admin.categories.index') }}">All Categories</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $category->name }}">
        </div>

        <div class="mb-3">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control" placeholder="Image">
            <img width="80" src="{{ asset('uploads/images/' . $category->image) }}" alt="">
        </div>

        <div class="mb-3">
            <label for="">Parent</label>
            <select class="form-control" name="parent_id">
                <option value="" selected disabled> >--Select--< </option>
                        @foreach ($categories as $item)
                <option {{ $category->parent_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                    {{ $item->name }}
                </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-info px-5">Save</button>
    </form>

@stop
