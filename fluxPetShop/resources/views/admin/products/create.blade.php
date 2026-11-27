@extends('layouts.app')

@section('title', 'Add Product — fluxPetShop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Add Product</h1>
            <p class="page-subtitle">Enter product details to add it to the catalog.</p>
        </div>
    </div>

    <section class="card">
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            @include('admin.products._form', ['product' => null, 'submitLabel' => 'Create Product'])
        </form>
    </section>
@endsection
