@extends('layouts.hayo')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Order Header -->
        <div class="bg-dark-red p-8 text-white">
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs font-bold uppercase tracking-widest opacity-80">Rincian Pesanan</span>
                <span class="bg-bright-yellow text-dark-red px-4 py-1 rounded-full text-xs font-black uppercase">{{ $order->status }}</span>
            </div>
            <h2 class="text-3xl font-black">#{{ $order->order_number }}</h2>
            <p class="text-sm opacity-80 mt-2">{{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>

        <div class="p-8">
            <!-- Items Table -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Menu yang Dipesan</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden">
                                <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : 'https://placehold.co/100x100?text=Food' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $item->product->name }}</div>
                                <div class="text-xs text-gray-400">Qty: {{ $item->qty }} x Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-6 border-t flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-800">Total Pembayaran</span>
                    <span class="text-2xl font-black text-dark-red">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Delivery & Payment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat Pengiriman</h4>
                    <p class="text-gray-700 leading-relaxed">{{ $order->delivery_address }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Metode Pembayaran</h4>
                    <p class="text-gray-700 font-bold">{{ strtoupper($order->payment_method) }}</p>
                </div>
            </div>

            <!-- Payment Receipt Upload -->
            @if($order->payment_method !== 'cash' && $order->status === 'pending')
            <div class="bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-200">
                <h4 class="font-bold text-gray-800 mb-2">Upload Bukti Transfer</h4>
                <p class="text-sm text-gray-500 mb-4">Silakan unggah foto bukti transfer Anda untuk memproses pesanan.</p>
                
                @if($order->payment_receipt)
                    <div class="mb-4">
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded text-xs font-bold">Bukti sudah diunggah</span>
                        <img src="{{ asset('storage/' . $order->payment_receipt) }}" class="mt-2 w-32 h-32 object-cover rounded-lg border">
                    </div>
                @endif

                <form action="{{ route('orders.receipt', $order->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-4">
                    @csrf
                    <input type="file" name="payment_receipt" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-dark-red file:text-white hover:file:bg-red-800 transition">
                    <button type="submit" class="bg-bright-yellow text-dark-red font-bold py-2 rounded-xl hover:bg-yellow-500 transition">Simpan Bukti</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    
    <div class="mt-8 text-center">
        <a href="{{ route('orders.index') }}" class="text-dark-red font-bold hover:underline">← Kembali ke Pesanan Saya</a>
    </div>
</div>
@endsection
