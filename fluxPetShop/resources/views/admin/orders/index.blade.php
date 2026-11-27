@extends('layouts.app')

@section('title', 'Manage Orders — fluxPetShop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manage Order Status</h1>
            <p class="page-subtitle">Move orders through Pending, Ready, and Completed.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Manage Catalog</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="card">
        @if ($orders->isEmpty())
            <p>No orders to manage yet.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Current Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order) }}">{{ $order->reference_number }}</a></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->product->name ?? 'Deleted product' }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.orders.status', $order) }}"
                                        style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-control" aria-label="Status for {{ $order->reference_number }}">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
