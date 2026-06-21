@extends('layouts.hayo')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="bg-white rounded-[4rem] shadow-2xl border border-gray-100 overflow-hidden flex flex-col md:flex-row items-stretch">
        <!-- Success Banner Side -->
        <div class="bg-dark-red w-full md:w-1/2 p-12 text-center flex flex-col items-center justify-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-2xl mb-8">
                <svg class="w-16 h-16 text-dark-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-black text-white tracking-tighter mb-4">Pesanan Berhasil!</h2>
            <p class="text-white/80 font-bold text-sm leading-relaxed max-w-xs">Tim Hayo Chicken sudah menerima pesananmu dan sedang menyiapkan bumbunya!</p>
        </div>

        <!-- Info Side -->
        <div class="w-full md:w-1/2 p-12 bg-bg-cream/50 flex flex-col justify-center">
            <div class="space-y-8 mb-12">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-3">Kode Order</p>
                    <p class="text-2xl font-black text-gray-800 tracking-tighter">#{{ $order->order_number }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Estimasi</p>
                        <p class="text-lg font-black text-dark-red">15-20 Menit</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Total</p>
                        <p class="text-lg font-black text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <a href="{{ route('orders.show', $order->id) }}" class="block w-full bg-dark-red text-white py-5 rounded-2xl font-black text-center shadow-xl hover:bg-bright-yellow hover:text-dark-red transition active:scale-95 uppercase tracking-widest text-xs">
                    Pantau Status Pesanan
                </a>
                <a href="/" class="block text-center font-black text-gray-400 uppercase tracking-widest text-[10px] hover:text-dark-red transition">
                    Lanjut Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
