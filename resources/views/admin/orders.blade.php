@extends('layouts.hayo')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Manajemen Pesanan</h2>
        <a href="{{ route('admin.dashboard') }}" class="text-dark-red font-bold hover:underline">← Dashboard</a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-widest">
                        <th class="px-8 py-4">Pesanan</th>
                        <th class="px-8 py-4">Pelanggan</th>
                        <th class="px-8 py-4">Metode</th>
                        <th class="px-8 py-4">Bukti</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-8 py-6">
                            <div class="font-bold text-gray-800">#{{ $order->order_number }}</div>
                            <div class="text-xs text-gray-400">{{ $order->created_at->format('d/m/Y') }}</div>
                            <div class="text-sm font-bold text-dark-red mt-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="font-bold text-gray-800">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $order->delivery_address }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold uppercase">{{ $order->payment_method }}</span>
                        </td>
                        <td class="px-8 py-6">
                            @if($order->payment_receipt)
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="text-blue-500 hover:underline text-xs font-bold">Lihat Bukti</a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold uppercase rounded-lg border-gray-200 focus:ring-dark-red focus:border-dark-red">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="verifying" {{ $order->status === 'verifying' ? 'selected' : '' }}>Verifikasi</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Dimasak</option>
                                    <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-8 py-6">
                            <button class="text-gray-400 hover:text-dark-red transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
