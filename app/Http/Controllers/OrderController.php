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
            'items' => 'required|array',
            'delivery_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $order = Order::create([
            'order_number' => 'HAYO-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'total_price' => 0, // Will be calculated
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'delivery_address' => $request->delivery_address,
        ]);

        $total = 0;
        foreach ($request->items as $item) {
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
            'order_number' => $order->order_number,
            'redirect' => route('orders.show', $order->id)
        ]);
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
