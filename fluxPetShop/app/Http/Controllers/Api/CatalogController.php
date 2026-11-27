<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $products = Product::query()
            ->with('category:id,name')
            ->orderBy('id')
            ->get(['id', 'category_id', 'name', 'description', 'price', 'stock']);

        return response()->json(['data' => $products]);
    }
}
