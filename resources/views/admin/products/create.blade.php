@extends('admin.master')
@section('title', 'All Products | ' . env('APP_NAME'))
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Product</h1>
        <a class="btn btn-dark" href="{{ route('admin.products.index') }}">All Products</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name">
        </div>

        <div class="mb-3">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control" placeholder="Image">
        </div>

        <div class="mb-3">
            <label for="">Description</label>
            <textarea id="tiny" type="file" name="description" class="form-control" placeholder="Type Your Description"
                rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label for="">Price</label>
            <input type="number" name="price" class="form-control" placeholder="Price" step="any">
        </div>

        <div class="mb-3">
            <label for="">Sale Price</label>
            <input type="number" name="sale_price" class="form-control" placeholder="Sale Price" step="any">
        </div>

        <div class="mb-3">
            <label for="">Quantity</label>
            <input type="number" name="quantity" class="form-control" placeholder="Quantity">
        </div>


        <div class="mb-3">
            <label for="">Category</label>
            <select class="form-control" name="category_id">
                <option value="" selected disabled> >--Select--< </option>
                        @foreach ($categories as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success px-5">Save</button>
    </form>

@stop
