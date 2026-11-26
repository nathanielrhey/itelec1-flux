@extends('layouts.app')

@section('title', 'Catalog — FLUX Pet Shop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Product Catalog</h1>
            <p class="page-subtitle">Browse all pet food, grooming supplies, and accessories with live inventory counts.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">View All Orders</a>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Place an Order</a>
        </div>
    </div>

    <section class="card filter-bar" aria-label="Catalog filters">
        <div class="filter-pills">
            <a
                href="{{ route('catalog', $search !== '' ? ['search' => $search] : []) }}"
                class="filter-pill {{ $selectedCategoryId === null ? 'active' : '' }}"
            >
                All Categories
            </a>
            @foreach ($allCategories as $cat)
                <a
                    href="{{ route('catalog', array_filter(['category' => $cat->id, 'search' => $search !== '' ? $search : null])) }}"
                    class="filter-pill {{ $selectedCategoryId === $cat->id ? 'active' : '' }}"
                >
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('catalog') }}" class="search-form">
            @if ($selectedCategoryId)
                <input type="hidden" name="category" value="{{ $selectedCategoryId }}">
            @endif
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search products..."
                class="form-control"
                style="width: 220px;"
            >
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if ($selectedCategoryId || $search !== '')
                <a href="{{ route('catalog') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>
    </section>

    @forelse ($categories as $category)
        <section class="category-section">
            <div class="category-header">
                <h2>{{ $category->name }}</h2>
                @if ($category->description)
                    <p>{{ $category->description }}</p>
                @endif
            </div>

            <div class="grid-3">
                @forelse ($category->products as $product)
                    <article class="card product-card">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: start; gap: 8px; margin-bottom: 8px;">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                @if ($product->stock <= 0)
                                    <span class="badge badge-danger">Out of stock</span>
                                @elseif ($product->stock <= 5)
                                    <span class="badge badge-warning">{{ $product->stock }} left</span>
                                @else
                                    <span class="badge badge-success">{{ $product->stock }} in stock</span>
                                @endif
                            </div>
                            <p class="product-desc">{{ $product->description }}</p>
                        </div>

                        <div class="product-meta">
                            <span class="price">&#8369;{{ number_format((float) $product->price, 2) }}</span>
                            <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" class="btn btn-primary btn-sm">
                                Order Item
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="card">No products match this filter in {{ $category->name }}.</div>
                @endforelse
            </div>
        </section>
    @empty
        <div class="card">
            <p style="margin: 0;">
                @if ($search !== '' || $selectedCategoryId)
                    No products matched your current filter. <a href="{{ route('catalog') }}">View all products</a>.
                @else
                    No categories or products found. Run <code>php artisan db:seed</code> to load sample items.
                @endif
            </p>
        </div>
    @endforelse
@endsection
