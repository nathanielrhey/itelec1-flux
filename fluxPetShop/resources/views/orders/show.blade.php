@extends('layouts.app')

@section('title', "Order {$order->reference_number} Status — fluxPetShop")

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Order Status: {{ $order->reference_number }}</h1>
            <p class="page-subtitle">Saved order record with linked product inventory and category details.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Place Another Order</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">All Orders</a>
            <a href="{{ route('catalog') }}" class="btn btn-secondary">Catalog</a>
        </div>
    </div>

    <div class="grid-2">
        <section class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h2 class="card-title" style="margin: 0;">Order Summary</h2>
                @if (strtolower($order->status) === 'completed')
                    <span class="badge badge-success">{{ $order->status }}</span>
                @else
                    <span class="badge badge-warning">{{ $order->status }}</span>
                @endif
            </div>

            <dl class="dl-grid">
                <dt>Reference No.</dt>
                <dd><strong>{{ $order->reference_number }}</strong> (ID #{{ $order->id }})</dd>

                <dt>Customer Name</dt>
                <dd>{{ $order->customer_name }}</dd>

                <dt>Quantity</dt>
                <dd>{{ $order->quantity }} unit(s)</dd>

                <dt>Total Price</dt>
                <dd><strong>&#8369;{{ number_format((float) $order->total_price, 2) }}</strong></dd>

                <dt>Status</dt>
                <dd>{{ $order->status }}</dd>

                <dt>Placed On</dt>
                <dd>{{ $order->created_at?->format('M d, Y h:i A') ?? '—' }}</dd>
            </dl>
        </section>

        <section class="card">
            <h2 class="card-title">Related Product &amp; Category</h2>

            <dl class="dl-grid">
                <dt>Product Name</dt>
                <dd><strong>{{ $order->product->name }}</strong></dd>

                <dt>Category</dt>
                <dd>{{ $order->product->category->name ?? 'Uncategorized' }}</dd>

                <dt>Unit Price</dt>
                <dd>&#8369;{{ number_format((float) $order->product->price, 2) }}</dd>

                <dt>Remaining Stock</dt>
                <dd>
                    @if ($order->product->stock <= 0)
                        <span class="badge badge-danger">0 left (Out of stock)</span>
                    @elseif ($order->product->stock <= 5)
                        <span class="badge badge-warning">{{ $order->product->stock }} left</span>
                    @else
                        <span class="badge badge-success">{{ $order->product->stock }} remaining</span>
                    @endif
                </dd>

                <dt>Description</dt>
                <dd>{{ $order->product->description ?? '—' }}</dd>
            </dl>
        </section>
    </div>

    <section class="card" style="margin-top: 20px;">
        <h2 class="card-title">Session Memory</h2>
        <dl class="dl-grid">
            <dt>Remembered Visitor</dt>
            <dd>{{ session('visitor_name') ?? 'Not set in current session' }}</dd>

            <dt>Last Order Ref</dt>
            <dd>{{ session('last_order_reference') ?? 'Not set in current session' }}</dd>
        </dl>
    </section>
@endsection
