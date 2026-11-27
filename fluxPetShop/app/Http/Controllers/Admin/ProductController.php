<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with('category')
            ->withCount('orders')
            ->orderBy('name')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(SaveProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$product->name} was created.");
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(SaveProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$product->name} was updated.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orders()->exists()) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'This product cannot be deleted because it has existing orders.');
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', "{$product->name} was deleted.");
    }
}
