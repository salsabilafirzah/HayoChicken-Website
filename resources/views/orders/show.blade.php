@extends('layouts.hayo')

@section('title', 'Status Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6 border-b border-gray-200 pb-10">
        <div class="space-y-2">
            <h2 class="text-5xl font-black text-dark-red tracking-tighter animate-in slide-in-from-left duration-700">Status Pesanan</h2>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Detail & Pelacakan Real-time</p>
        </div>
        <div class="bg-dark-red text-white px-8 py-4 rounded-3xl shadow-xl border-b-4 border-black/20 flex items-center space-x-6">
            <div class="pr-6 border-r border-white/20">
                <p class="text-[10px] font-black text-white/60 uppercase mb-1">Order ID</p>
                <p class="text-xl font-black tracking-tighter">#{{ $order->order_number }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-white/60 uppercase mb-1">Status</p>
                <p class="text-xl font-black capitalize tracking-tight text-bright-yellow">{{ $order->status }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Logistics & Progress (2 cols) -->
        <div class="lg:col-span-2 space-y-10">
            <!-- New Horizontal Progress Tracker -->
            <div class="bg-white p-12 rounded-[3.5rem] shadow-xl border border-gray-100">
                <div class="relative flex justify-between">
                    @php
                        $isQris = strtolower($order->payment_method) === 'qris';
                        if ($isQris) {
                            $steps = [
                                ['label' => 'Diterima', 'status' => 'pending'],
                                ['label' => 'Verifikasi', 'status' => 'verifying'],
                                ['label' => 'Dimasak', 'status' => 'processing'],
                                ['label' => 'Dikirim', 'status' => 'shipping'],
                                ['label' => 'Selesai', 'status' => 'completed']
                            ];
                        } else {
                            $steps = [
                                ['label' => 'Diterima', 'status' => 'pending'],
                                ['label' => 'Dimasak', 'status' => 'processing'],
                                ['label' => 'Dikirim', 'status' => 'shipping'],
                                ['label' => 'Selesai', 'status' => 'completed']
                            ];
                        }

                        $statusOrder = array_column($steps, 'status');
                        $currentIdx = array_search($order->status, $statusOrder);
                        if ($currentIdx === false) $currentIdx = 0;
                        
                        $progressWidth = (count($steps) > 1) ? ($currentIdx / (count($steps) - 1)) * 100 : 0;
                    @endphp

                    <!-- Progress Background Line -->
                    <div class="absolute top-8 left-0 w-full h-1 bg-gray-100 z-0"></div>
                    <div class="absolute top-8 left-0 h-1 bg-dark-red z-0 transition-all duration-1000" 
                        style="width: {{ $progressWidth }}%">
                    </div>

                    @foreach($steps as $index => $step)
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center text-xl shadow-lg border-4 transition duration-700
                            {{ ($order->status === $step['status'] || ($index < $currentIdx)) ? 'bg-dark-red border-bright-yellow text-white scale-110' : 'bg-white border-gray-100 text-gray-300' }}">
                            @if($index < $currentIdx)
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <span class="font-black">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <p class="mt-4 text-[10px] font-black uppercase tracking-widest {{ ($order->status === $step['status']) ? 'text-dark-red' : 'text-gray-400' }}">
                            {{ $step['label'] }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="bg-gray-50 p-10 rounded-[3rem] border border-gray-200">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Informasi Pengiriman</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Alamat Pengiriman</p>
                        <p class="text-sm font-bold text-gray-800 leading-relaxed">{{ $order->delivery_address }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Metode Pembayaran</p>
                        <p class="text-sm font-black text-dark-red uppercase">{{ $order->payment_method }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Order Items & Total (1 col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden">
                <div class="bg-bg-cream px-8 py-6 border-b border-gray-100">
                    <h4 class="text-xs font-black text-dark-red uppercase tracking-widest text-center">Ringkasan Pesanan</h4>
                </div>
                <div class="p-8 space-y-6">
                    <div class="space-y-4 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                        @foreach($order->items as $item)
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-bg-cream rounded-xl flex-shrink-0 flex items-center justify-center font-black text-dark-red overflow-hidden">
                                <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : (Str::startsWith($item->product->image, 'images/') ? asset($item->product->image) : asset('storage/' . $item->product->image)) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black text-gray-800 truncate">{{ $item->product->name }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $item->qty }}x @ Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-black text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-dashed border-gray-100 pt-6 space-y-3">
                        <div class="flex justify-between text-sm font-bold text-gray-400 uppercase">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-green-500 uppercase">
                            <span>Ongkos Kirim</span>
                            <span>GRATIS</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                            <span class="text-xl font-black text-gray-800 uppercase">Total</span>
                            <span class="text-3xl font-black text-dark-red tracking-tighter">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="/" class="block w-full bg-dark-red text-white py-5 rounded-2xl font-black text-center shadow-xl hover:bg-bright-yellow hover:text-dark-red transition active:scale-95 uppercase tracking-widest text-xs">
                        Kembali Ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
