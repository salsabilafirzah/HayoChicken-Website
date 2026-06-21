@extends('layouts.hayo')

@section('title', 'Menu Utama')

@section('content')
<!-- Hero Section -->
<section class="bg-dark-red text-white py-20 px-6 overflow-hidden relative">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between relative z-10">
        <div class="md:w-1/2 space-y-6">
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Berani Coba, <br>
                <span class="text-bright-yellow">Berani Ketagihan!</span>
            </h1>
            <p class="text-xl text-gray-200 max-w-lg">
                Rasakan sensasi ayam goreng paling renyah dengan bumbu yang meresap sampai ke tulang. Pesan sekarang dan nikmati kelezatannya!
            </p>
            <div class="pt-4">
                <a href="#menu" class="btn-primary text-xl">Pesan Sekarang</a>
            </div>
        </div>
        <div class="md:w-1/2 mt-12 md:mt-0 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-bright-yellow/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-bright-yellow/20 rounded-full blur-3xl"></div>
            <img src="{{ asset('images/logo.png') }}" alt="Hayo Chicken Hero" class="w-full max-w-md mx-auto drop-shadow-2xl animate-pulse">
        </div>
    </div>
    
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-12 transform translate-x-20"></div>
</section>

<!-- Category Filter -->
<div id="menu" class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-wrap items-center justify-between mb-10 gap-4">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Menu Kami</h2>
        
        <div class="flex space-x-2">
            <button class="px-6 py-2 rounded-full bg-bright-yellow text-dark-red font-bold shadow-md hover:bg-yellow-500 transition">Semua</button>
            @foreach($categories as $category)
                <button class="px-6 py-2 rounded-full bg-white text-gray-600 font-bold border border-gray-200 hover:border-bright-yellow hover:text-dark-red transition">{{ $category->category }}</button>
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($products as $product)
        <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-500 group border border-gray-100 flex flex-col h-full">
            <div class="relative h-64 overflow-hidden">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : 'https://placehold.co/600x400?text=' . urlencode($product->name) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute top-4 right-4">
                    <button onclick="toggleFavorite({{ json_encode($product) }})" id="fav-btn-{{ $product->id }}" class="w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition shadow-lg">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </button>
                </div>
                <div class="absolute bottom-0 left-0 bg-bright-yellow text-dark-red px-6 py-2 font-black rounded-tr-3xl shadow-lg">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
            
            <div class="p-8 flex-grow flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">{{ $product->category }}</span>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-dark-red transition">{{ $product->name }}</h3>
                    <p class="text-gray-500 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </span>
                        <span class="font-bold text-gray-700">4.9</span>
                    </div>
                    <button onclick="addToCart({{ $product->id }})" class="bg-dark-red text-white p-3 rounded-2xl hover:bg-red-800 transition shadow-lg flex items-center space-x-2 group/btn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="font-bold pr-2">Tambah</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function addToCart(productId) {
        const product = @json($products).find(p => p.id === productId);
        if (!product) return;

        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const existing = cart.find(item => item.id === productId);
        
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                image: product.image.startsWith('http') ? product.image : 'https://placehold.co/600x400?text=' + encodeURIComponent(product.name),
                qty: 1
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));

        // Simple visual feedback
        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
        
        setTimeout(() => {
            btn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            btn.classList.replace('bg-dark-red', 'bg-green-500');
            
            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.innerText = cart.length;
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.replace('bg-green-500', 'bg-dark-red');
            }, 1000);
        }, 500);
    }

    function toggleFavorite(product) {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const index = favorites.findIndex(f => f.id === product.id);
        const btn = document.getElementById(`fav-btn-${product.id}`);
        
        if (index > -1) {
            favorites.splice(index, 1);
            btn.classList.replace('text-red-500', 'text-gray-400');
        } else {
            favorites.push({
                id: product.id,
                name: product.name,
                category: product.category,
                price: product.price,
                image: product.image.startsWith('http') ? product.image : 'https://placehold.co/600x400?text=' + encodeURIComponent(product.name)
            });
            btn.classList.replace('text-gray-400', 'text-red-500');
        }
        
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }

    function syncFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        favorites.forEach(f => {
            const btn = document.getElementById(`fav-btn-${f.id}`);
            if (btn) {
                btn.classList.replace('text-gray-400', 'text-red-500');
            }
        });
    }

    // Sync cart count and favorites on load
    document.addEventListener('DOMContentLoaded', () => {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const cartCount = document.getElementById('cart-count');
        if (cartCount) cartCount.innerText = cart.length;
        syncFavorites();
    });
</script>
@endpush
@endsection
