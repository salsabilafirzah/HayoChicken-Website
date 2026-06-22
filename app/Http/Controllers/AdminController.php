<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            
            // Payment Methods Summary
            'revenue_qris' => Order::where('status', 'completed')->whereIn('payment_method', ['qris', 'QRIS'])->sum('total_price'),
            'revenue_cod' => Order::where('status', 'completed')->whereIn('payment_method', ['cash', 'CASH', 'cod', 'COD'])->sum('total_price'),
            
            // Monthly Trend (Dummy for chart)
            'monthly_sales' => [1200, 1900, 3000, 5000, 2000, 3000],
        ];
        
        // Top Selling Products based on quantity sold in completed orders
        $top_products = Product::withSum(['orderItems as total_sold' => function($query) {
            $query->whereHas('order', function($q) {
                $q->where('status', 'completed');
            });
        }], 'qty')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();
            
        $recent_orders = Order::with('user')->latest()->take(5)->get();
        
        // Detailed Payment Summary (Completed Orders)
        $report_orders = Order::with(['user', 'items.product'])
            ->where('status', 'completed')
            ->latest()
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products', 'report_orders'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,verifying,processing,shipping,completed,cancelled',
        ]);
        
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
