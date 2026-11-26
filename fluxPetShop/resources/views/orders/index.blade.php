@extends('layouts.app')

@section('title', 'Orders — fluxPetShop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Customer Orders</h1>
            <p class="page-subtitle">Select any order to inspect its status page and related product inventory.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('catalog') }}" class="btn btn-secondary">Back to Catalog</a>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Place an Order</a>
        </div>
    </div>

    <section class="card">
        @if ($orders->isEmpty())
            <p style="margin: 0;">No orders have been placed yet. <a href="{{ route('orders.create') }}">Create the first order</a>.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="{{ (int) session('last_order_id') === $order->id ? 'highlight-row' : '' }}">
                                <td>
                                    <strong>{{ $order->reference_number }}</strong>
                                    @if ((int) session('last_order_id') === $order->id)
                                        <span class="badge badge-info">Session</span>
                                    @endif
                                </td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->product->name ?? 'Deleted product' }}</td>
                                <td>{{ $order->product->category->name ?? '—' }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>&#8369;{{ number_format((float) $order->total_price, 2) }}</td>
                                <td>
                                    @if (strtolower($order->status) === 'completed')
                                        <span class="badge badge-success">{{ $order->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary btn-sm">View Status</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
