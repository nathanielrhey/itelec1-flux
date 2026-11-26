<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    /**
     * Display the dedicated pet shop front page.
     */
    public function home(): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::query()
            ->with('category')
            ->orderByDesc('stock')
            ->orderBy('id')
            ->limit(3)
            ->get();

        $stats = [
            'categories' => $categories->count(),
            'products' => Product::count(),
            'in_stock_units' => (int) Product::sum('stock'),
            'orders' => Order::count(),
        ];

        return view('home', compact('categories', 'featuredProducts', 'stats'));
    }

    /**
     * Display the dedicated pet shop product catalog with optional filtering.
     */
    public function catalog(Request $request): View
    {
        $selectedCategoryId = $request->integer('category') ?: null;
        $search = trim((string) $request->query('search', ''));

        $allCategories = Category::query()
            ->orderBy('name')
            ->get();

        $categoriesQuery = Category::query()->orderBy('name');

        if ($selectedCategoryId) {
            $categoriesQuery->whereKey($selectedCategoryId);
        }

        if ($search !== '') {
            $categoriesQuery->whereHas('products', function ($query) use ($search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });
        }

        $categories = $categoriesQuery
            ->with(['products' => function ($query) use ($search): void {
                $query->orderBy('name');

                if ($search !== '') {
                    $query->where(function ($subQuery) use ($search): void {
                        $subQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                }
            }])
            ->get();

        return view('catalog.index', compact(
            'categories',
            'allCategories',
            'selectedCategoryId',
            'search'
        ));
    }
}
