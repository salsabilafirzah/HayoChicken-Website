@extends('layouts.hayo')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Dashboard Admin</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.orders') }}" class="px-6 py-2 rounded-full bg-white text-dark-red font-bold border border-dark-red hover:bg-dark-red hover:text-white transition">Kelola Pesanan</a>
            <a href="{{ route('admin.products') }}" class="px-6 py-2 rounded-full bg-bright-yellow text-dark-red font-bold shadow-md hover:bg-yellow-500 transition">Kelola Produk</a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-2">Total Pendapatan</p>
            <h3 class="text-3xl font-black text-dark-red">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-2">Total Pesanan</p>
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_orders'] }}</h3>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-2">Menunggu Proses</p>
            <h3 class="text-3xl font-black text-orange-500">{{ $stats['pending_orders'] }}</h3>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-2">Total Menu</p>
            <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_products'] }}</h3>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders') }}" class="text-dark-red font-bold hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-widest">
                        <th class="px-8 py-4">No. Pesanan</th>
                        <th class="px-8 py-4">Pelanggan</th>
                        <th class="px-8 py-4">Total</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent_orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-8 py-6 font-bold text-gray-800">#{{ $order->order_number }}</td>
                        <td class="px-8 py-6">
                            <div class="font-bold text-gray-800">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-8 py-6 font-bold text-dark-red">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-8 py-6">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-orange-100 text-orange-600',
                                    'processing' => 'bg-blue-100 text-blue-600',
                                    'completed' => 'bg-green-100 text-green-600',
                                    'cancelled' => 'bg-red-100 text-red-600',
                                ];
                            @endphp
                            <span class="px-4 py-1 rounded-full text-xs font-bold uppercase {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <a href="{{ route('admin.orders') }}" class="text-bright-yellow hover:text-dark-red transition font-bold">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-gray-400 italic">Belum ada pesanan terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
