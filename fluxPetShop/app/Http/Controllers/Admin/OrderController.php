<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const STATUSES = ['Pending', 'Ready', 'Completed'];

    public function index(): View
    {
        $orders = Order::query()
            ->with('product')
            ->latest('id')
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(self::STATUSES)],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "{$order->reference_number} is now {$order->status}.");
    }
}
