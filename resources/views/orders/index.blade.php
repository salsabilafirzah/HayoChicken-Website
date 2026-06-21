@extends('layouts.hayo')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Pesanan Saya</h2>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($orders as $order)
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition flex flex-col md:flex-row">
            <div class="p-8 flex-grow">
                <div class="flex justify-between items-center">
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">#{{ $order->order_number }}</span>
                            <h3 class="text-xl font-bold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</h3>
                        </div>
                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                            <div>
                                <span class="block font-bold text-gray-400 uppercase text-[10px]">Total</span>
                                <span class="text-dark-red font-black text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-gray-400 uppercase text-[10px]">Pembayaran</span>
                                <span class="font-bold text-gray-700 capitalize">{{ $order->payment_method }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @php
                        $statusClasses = [
                            'pending' => 'bg-orange-100 text-orange-600',
                            'verifying' => 'bg-purple-100 text-purple-600',
                            'processing' => 'bg-blue-100 text-blue-600',
                            'shipping' => 'bg-indigo-100 text-indigo-600',
                            'completed' => 'bg-green-100 text-green-600',
                            'cancelled' => 'bg-red-100 text-red-600',
                        ];
                    @endphp
                    <span class="px-6 py-2.5 rounded-xl text-xs font-black capitalize shadow-sm {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
            <div class="bg-gray-50 px-8 py-6 md:w-48 flex flex-col justify-center items-center border-t md:border-t-0 md:border-l border-gray-100">
                <a href="{{ route('orders.show', $order->id) }}" class="w-full text-center py-2.5 bg-dark-red text-white rounded-xl font-bold hover:bg-bright-yellow hover:text-dark-red transition shadow-md">Detail</a>
                @if($order->status === 'pending' && !$order->payment_receipt && $order->payment_method !== 'cash')
                    <span class="text-[10px] text-orange-500 font-bold uppercase text-center animate-pulse">Butuh Bukti Transfer</span>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-3xl p-20 text-center shadow-xl border border-gray-100">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada pesanan</h3>
            <p class="text-gray-500 mb-8">Sepertinya Anda belum memesan apapun hari ini. Yuk, coba menu spesial kami!</p>
            <a href="/" class="btn-primary">Lihat Menu</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
