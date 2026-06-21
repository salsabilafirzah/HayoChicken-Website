@extends('layouts.hayo')

@section('title', 'Manajemen Produk')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Manajemen Produk</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="text-dark-red font-bold hover:underline">← Dashboard</a>
            <button class="bg-bright-yellow text-dark-red px-6 py-2 rounded-full font-black shadow-lg hover:bg-yellow-500 transition">Tambah Menu</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($products as $product)
        <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex flex-col">
            <div class="relative h-48">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : 'https://placehold.co/600x400?text=' . urlencode($product->name) }}" class="w-full h-full object-cover">
                <div class="absolute top-4 right-4 flex space-x-2">
                    <button class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-blue-500 shadow-sm hover:bg-blue-500 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-red-500 shadow-sm hover:bg-red-500 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $product->category }}</span>
                        <h3 class="font-bold text-gray-800 text-lg">{{ $product->name }}</h3>
                    </div>
                    <div class="text-right">
                        <div class="font-black text-dark-red">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-bold {{ $product->is_available ? 'text-green-500' : 'text-red-500' }}">
                        ● {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" {{ $product->is_available ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-dark-red"></div>
                    </label>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $products->links() }}
    </div>
</div>
@endsection
