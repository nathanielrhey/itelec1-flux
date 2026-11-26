@extends('layouts.app')

@section('title', 'Place Order — fluxPetShop')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Place a Pet Shop Order</h1>
            <p class="page-subtitle">Orders are validated and saved atomically with product stock updates inside a database transaction.</p>
        </div>
        <a href="{{ route('catalog') }}" class="btn btn-secondary">Back to Catalog</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Please fix the following errors before submitting your order:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-layout">
        <section class="card">
            <h2 class="card-title">Order Request Form</h2>

            <form method="POST" action="{{ route('orders.store') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        value="{{ old('customer_name', session('visitor_name')) }}"
                        placeholder="e.g. Angela Santos"
                        class="form-control @error('customer_name') is-invalid @enderror"
                    >
                    @error('customer_name')
                        <div class="field-error">{{ $message }}</div>
                    @elseif (session('visitor_name') && ! old('customer_name'))
                        <div class="form-hint">Pre-filled from your session visitor name.</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="product_id" class="form-label">Select Product</label>
                    @php
                        $currentProductId = (string) old('product_id', $selectedProductId ?? '');
                    @endphp
                    <select
                        id="product_id"
                        name="product_id"
                        class="form-control @error('product_id') is-invalid @enderror"
                    >
                        <option value="">-- Choose a product --</option>
                        @foreach ($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach ($category->products as $product)
                                    <option
                                        value="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-category="{{ $category->name }}"
                                        data-price="{{ number_format((float) $product->price, 2, '.', '') }}"
                                        data-stock="{{ $product->stock }}"
                                        @selected($currentProductId === (string) $product->id)
                                    >
                                        {{ $product->name }} — &#8369;{{ number_format((float) $product->price, 2) }} ({{ $product->stock }} in stock)
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity', 1) }}"
                        min="1"
                        class="form-control @error('quantity') is-invalid @enderror"
                    >
                    @error('quantity')
                        <div class="field-error">{{ $message }}</div>
                    @else
                        <div class="form-hint">Must be at least 1 and cannot exceed available stock.</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-primary">Submit Order</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">View Orders</a>
                </div>
            </form>
        </section>

        <aside class="card">
            <h2 class="card-title">Live Order Summary</h2>
            <dl class="dl-grid" id="order-preview">
                <dt>Product</dt>
                <dd id="preview-name">None selected</dd>

                <dt>Category</dt>
                <dd id="preview-category">—</dd>

                <dt>Unit Price</dt>
                <dd id="preview-price">&#8369;0.00</dd>

                <dt>Available Stock</dt>
                <dd id="preview-stock">—</dd>

                <dt>Estimated Total</dt>
                <dd id="preview-total" style="font-size: 1.15rem; font-weight: 700; color: var(--primary-dark);">&#8369;0.00</dd>
            </dl>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 18px 0;">

            <p style="margin: 0; font-size: 0.87rem; color: var(--muted);">
                <strong>Atomic Save:</strong> Submitting creates an entry in <code>orders</code> and deducts stock in <code>products</code> inside one <code>DB::transaction()</code>. If stock is insufficient or an error occurs, both changes are rolled back.
            </p>
        </aside>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const previewName = document.getElementById('preview-name');
        const previewCategory = document.getElementById('preview-category');
        const previewPrice = document.getElementById('preview-price');
        const previewStock = document.getElementById('preview-stock');
        const previewTotal = document.getElementById('preview-total');

        function formatCurrency(value) {
            return '\u20B1' + Number(value).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function updatePreview() {
            const option = productSelect.options[productSelect.selectedIndex];
            const qty = Math.max(0, parseInt(quantityInput.value || '0', 10) || 0);

            if (!option || !option.value) {
                previewName.textContent = 'None selected';
                previewCategory.textContent = '\u2014';
                previewPrice.textContent = formatCurrency(0);
                previewStock.textContent = '\u2014';
                previewTotal.textContent = formatCurrency(0);
                return;
            }

            const price = parseFloat(option.dataset.price || '0');
            const stock = parseInt(option.dataset.stock || '0', 10);

            previewName.textContent = option.dataset.name || option.textContent;
            previewCategory.textContent = option.dataset.category || '\u2014';
            previewPrice.textContent = formatCurrency(price);
            previewStock.textContent = stock + ' unit(s)';
            previewTotal.textContent = formatCurrency(price * qty);
        }

        productSelect.addEventListener('change', updatePreview);
        quantityInput.addEventListener('input', updatePreview);
        updatePreview();
    })();
</script>
@endpush
