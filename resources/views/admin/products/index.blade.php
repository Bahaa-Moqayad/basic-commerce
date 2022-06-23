@extends('admin.master')
@section('title', 'All Products | ' . env('APP_NAME'))
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Categories</h1>
        <a class="btn btn-dark" href="{{ route('admin.products.create') }}">Add New Product</a>
    </div>

    @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
        </div>
    @endif

    <table class="table table-bordered table-striped table-hover">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Sale Price</th>
            <th>Category</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td><img width="100" src="{{ asset('uploads/images/' . $product->image) }}" alt=""></td>
                <td>
                    @if ($product->quantity > 20)
                        <span class="badge badge-success">{{ $product->quantity }}</span>
                    @else
                        <span class="badge badge-danger">{{ $product->quantity }}</span>
                    @endif
                </td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->sale_price }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->created_at->diffForHumans() }}</td>
                <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', $product->id) }}"><i
                            class="fas fa-edit"></i></a>
                    <form class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}"
                        method="POST">
                        @csrf
                        @method('delete')
                        <button onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-danger"><i
                                class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center text-danger">No Data Yet</td>
            </tr>
        @endforelse
    </table>
    {{ $products->links() }}
@stop
