<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required',
            'delivery_address' => 'required|string',
            'payment_method' => 'required|string',
            'payment_receipt' => 'nullable|image|max:2048',
        ]);

        $items = is_string($request->items) ? json_decode($request->items, true) : $request->items;

        // Generate HC-YYYYMMDD-0001 format based on total orders
        $today = date('Ymd');
        $count = Order::count() + 1;
        $orderNumber = 'HC-' . $today . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->id(),
            'total_price' => 0,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'delivery_address' => $request->delivery_address,
        ]);

        if ($request->hasFile('payment_receipt')) {
            $path = $request->file('payment_receipt')->store('receipts', 'public');
            $order->update(['payment_receipt' => $path]);
        }

        $total = 0;
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            $subtotal = $product->price * $item['qty'];
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'qty' => $item['qty'],
                'price_at_purchase' => $product->price,
                'subtotal' => $subtotal,
            ]);
            
            $total += $subtotal;
        }

        $order->update(['total_price' => $total]);

        return response()->json([
            'success' => true,
            'redirect' => route('orders.success', $order->id)
        ]);
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('orders.success', compact('order'));
    }

    public function uploadReceipt(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_receipt' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('payment_receipt')) {
            $path = $request->file('payment_receipt')->store('receipts', 'public');
            $order->update(['payment_receipt' => $path]);
        }

        return back()->with('success', 'Bukti transfer berhasil diunggah.');
    }
}
