@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>Please fix the following errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="name" class="form-label">Product Name</label>
    <input id="name" name="name" value="{{ old('name', $product?->name) }}" maxlength="255"
        class="form-control @error('name') is-invalid @enderror" required>
    @error('name') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="category_id" class="form-label">Category</label>
    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
        <option value="">-- Choose a category --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="4" maxlength="5000"
        class="form-control @error('description') is-invalid @enderror">{{ old('description', $product?->description) }}</textarea>
    @error('description') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="price" class="form-label">Price (PHP)</label>
    <input id="price" name="price" type="number" step="0.01" min="0"
        value="{{ old('price', $product?->price) }}" class="form-control @error('price') is-invalid @enderror" required>
    @error('price') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="stock" class="form-label">Stock</label>
    <input id="stock" name="stock" type="number" min="0"
        value="{{ old('stock', $product?->stock ?? 0) }}" class="form-control @error('stock') is-invalid @enderror" required>
    @error('stock') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</div>
