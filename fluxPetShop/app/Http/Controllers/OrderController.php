<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display all orders with their related product and category.
     */
    public function index(): View
    {
        $orders = Order::query()
            ->with('product.category')
            ->latest('id')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the order creation form.
     */
    public function create(Request $request): View
    {
        $categories = Category::query()
            ->with(['products' => fn ($query) => $query->orderBy('name')])
            ->orderBy('name')
            ->get();

        $selectedProductId = $request->integer('product_id') ?: null;

        return view('orders.create', compact('categories', 'selectedProductId'));
    }

    /**
     * Validate and save a new order while decrementing product stock atomically.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $order = DB::transaction(function () use ($validated) {
                $product = Product::query()
                    ->whereKey($validated['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $validated['quantity'];
                $totalPrice = round(((float) $product->price) * $quantity, 2);

                $order = Order::create([
                    'product_id' => $product->id,
                    'customer_name' => $validated['customer_name'],
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'status' => 'Pending',
                ]);

                if ((int) $product->stock < $quantity) {
                    throw new InsufficientStockException($product->name, (int) $product->stock);
                }

                $product->decrement('stock', $quantity);

                return $order;
            });
        } catch (InsufficientStockException $e) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => $e->getMessage()]);
        }

        $order->load('product');

        $request->session()->put([
            'visitor_name' => $order->customer_name,
            'last_order_id' => $order->id,
            'last_order_reference' => $order->reference_number,
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with(
                'success',
                "Order {$order->reference_number} was placed successfully! Stock for {$order->product->name} has been updated."
            );
    }

    /**
     * Display the status page for a saved order and its related records.
     */
    public function show(Order $order): View
    {
        $order->load('product.category');

        return view('orders.show', compact('order'));
    }

    /**
     * Redirect to the latest order saved in the current session, if available.
     */
    public function status(Request $request): RedirectResponse
    {
        $lastOrderId = $request->session()->get('last_order_id');

        if ($lastOrderId && ($order = Order::find($lastOrderId))) {
            return redirect()->route('orders.show', $order);
        }

        return redirect()
            ->route('orders.index')
            ->with('info', 'No recent order found in this session yet. Choose an order below or place a new one.');
    }

    /**
     * Clear the remembered visitor name and order reference from the session.
     */
    public function forgetVisitor(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'visitor_name',
            'last_order_id',
            'last_order_reference',
        ]);

        return redirect()
            ->back(302, [], route('home'))
            ->with('info', 'Remembered customer session details were cleared.');
    }
}
