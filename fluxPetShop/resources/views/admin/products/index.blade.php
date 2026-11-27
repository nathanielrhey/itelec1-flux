@extends('layouts.app')

@section('title', 'Manage Products — fluxPetShop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manage Catalog</h1>
            <p class="page-subtitle">Create, edit, and remove products in the catalog.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Manage Order Status</a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <section class="card">
        @if ($products->isEmpty())
            <p>No products yet. <a href="{{ route('admin.products.create') }}">Add the first product</a>.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Orders</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>&#8369;{{ number_format((float) $product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->orders_count }}</td>
                                <td>
                                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">Edit</a>
                                        <form
                                            method="POST"
                                            action="{{ route('admin.products.destroy', $product) }}"
                                            onsubmit="return confirm('Delete this product? This cannot be undone.');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
