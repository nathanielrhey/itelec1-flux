@extends('layouts.app')

@section('title', 'Edit Product — fluxPetShop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Product</h1>
            <p class="page-subtitle">Update {{ $product->name }} in the catalog.</p>
        </div>
    </div>

    <section class="card">
        <form method="POST" action="{{ route('admin.products.update', $product) }}">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['submitLabel' => 'Save Changes'])
        </form>
    </section>
@endsection
