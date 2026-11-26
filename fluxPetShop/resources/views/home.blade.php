@extends('layouts.app')

@section('title', 'Home — FLUX Pet Shop')

@section('content')
    <section class="landing-hero">
        <div>
            <span class="landing-eyebrow">FLUX Pet Shop &middot; Group flux</span>
            <h1 class="landing-title">Quality Care &amp; Supplies for Dogs and Cats</h1>
            <p class="landing-copy">
                Explore daily nutrition, gentle grooming essentials, and durable accessories with live inventory tracking and atomic order processing.
            </p>
            <div class="landing-actions">
                <a href="{{ route('catalog') }}" class="btn btn-primary">Browse Catalog</a>
                <a href="{{ route('orders.create') }}" class="btn btn-secondary">Place an Order</a>
                @if (session('last_order_id') && session('last_order_reference'))
                    <a href="{{ route('orders.show', session('last_order_id')) }}" class="btn btn-secondary">
                        Track {{ session('last_order_reference') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="landing-logo-box">
            <img src="{{ asset('images/flux-logo.png') }}" alt="FLUX Pet Shop Logo" class="landing-logo-img">
        </div>
    </section>

    <section class="stats-grid" aria-label="Store summary">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['categories'] }}</div>
            <div class="stat-label">Product Categories</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['products'] }}</div>
            <div class="stat-label">Catalog Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['in_stock_units'] }}</div>
            <div class="stat-label">Units Available</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['orders'] }}</div>
            <div class="stat-label">Orders Recorded</div>
        </div>
    </section>

    <section style="margin-bottom: 32px;">
        <div class="page-header" style="margin-bottom: 16px;">
            <div>
                <h2 class="card-title" style="margin: 0; font-size: 1.3rem;">Shop by Category</h2>
                <p class="page-subtitle">Jump straight into a filtered section of the catalog.</p>
            </div>
            <a href="{{ route('catalog') }}" class="btn btn-secondary btn-sm">Open Full Catalog</a>
        </div>

        <div class="grid-3">
            @forelse ($categories as $category)
                <article class="card product-card">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <h3 class="product-name" style="margin: 0;">{{ $category->name }}</h3>
                            <span class="badge badge-info">{{ $category->products_count }} items</span>
                        </div>
                        <p class="product-desc">{{ $category->description ?? 'Explore available pet supplies.' }}</p>
                    </div>
                    <div class="product-meta">
                        <span class="form-hint" style="margin: 0;">Updated stock</span>
                        <a href="{{ route('catalog', ['category' => $category->id]) }}" class="btn btn-primary btn-sm">
                            Browse Category
                        </a>
                    </div>
                </article>
            @empty
                <div class="card">No categories available yet.</div>
            @endforelse
        </div>
    </section>

    <section style="margin-bottom: 32px;">
        <div class="page-header" style="margin-bottom: 16px;">
            <div>
                <h2 class="card-title" style="margin: 0; font-size: 1.3rem;">Featured Supplies</h2>
                <p class="page-subtitle">Popular items ready for immediate ordering.</p>
            </div>
            <a href="{{ route('catalog') }}" class="btn btn-secondary btn-sm">See All Products</a>
        </div>

        <div class="grid-3">
            @forelse ($featuredProducts as $product)
                <article class="card product-card">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: start; gap: 8px; margin-bottom: 8px;">
                            <div>
                                <div class="form-hint" style="margin: 0 0 4px;">{{ $product->category->name ?? 'Pet Supply' }}</div>
                                <h3 class="product-name" style="margin: 0;">{{ $product->name }}</h3>
                            </div>
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
                <div class="card">No products seeded yet.</div>
            @endforelse
        </div>
    </section>

    <section class="card">
        <h2 class="card-title">How Ordering Works</h2>
        <div class="grid-3">
            <div>
                <strong>1. Browse the Catalog</strong>
                <p class="product-desc" style="margin-top: 4px;">Filter by category or search products and inspect current stock before ordering.</p>
            </div>
            <div>
                <strong>2. Atomic Transaction Save</strong>
                <p class="product-desc" style="margin-top: 4px;">Submitting saves the order and reduces product stock together inside <code>DB::transaction()</code>.</p>
            </div>
            <div>
                <strong>3. Session &amp; Status Tracking</strong>
                <p class="product-desc" style="margin-top: 4px;">Your visitor name and latest order reference are remembered so you can check order status anytime.</p>
            </div>
        </div>
    </section>
@endsection
