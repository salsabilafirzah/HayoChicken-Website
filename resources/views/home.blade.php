@extends('layouts.hayo')

@section('title', 'Menu Utama')

@section('content')
    @auth
        <!-- Dynamic Hero Slider (FOR AUTHENTICATED USERS) -->
        <section class="px-6 py-8" x-data="{ 
            activeSlide: 1, 
            totalSlides: 3,
            autoPlay() {
                setInterval(() => {
                    this.activeSlide = this.activeSlide === this.totalSlides ? 1 : this.activeSlide + 1;
                }, 6000);
            }
        }" x-init="autoPlay()">
            <div class="max-w-7xl mx-auto relative h-[300px] md:h-[400px] overflow-hidden rounded-[3rem] shadow-2xl border-b-4 border-black/10">
                
                <!-- Slide 1: Promo Es Teh (Friday Only) -->
                <div x-show="activeSlide === 1" x-transition.opacity.duration.1000ms class="absolute inset-0 bg-gradient-to-br from-green-600 to-green-900 flex items-center px-12 md:px-24">
                    <div class="absolute -top-10 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 left-10 w-32 h-32 bg-yellow-400/10 rounded-full blur-2xl"></div>
                    
                    <div class="flex-1 text-white relative z-10">
                        <span class="inline-block bg-bright-yellow text-dark-red px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4">Limited Promo</span>
                        <h2 class="text-4xl md:text-7xl font-black mb-2 leading-none drop-shadow-lg">Promo <br><span class="text-bright-yellow">Jumat Berkah!</span></h2>
                        <p class="text-lg md:text-xl font-medium opacity-90 mb-8 max-w-md">Klaim sekarang & dapatkan FREE Es Teh segar setiap pembelian hari Jumat.</p>
                        <button 
                            @click="localStorage.setItem('claimed_teh', 'true'); alert('Promo diklaim! 🍵 Free Es Teh akan otomatis muncul di keranjangmu setiap hari Jumat.')" 
                            class="bg-white text-green-900 px-10 py-4 rounded-full font-black text-lg hover:bg-bright-yellow hover:scale-110 transition shadow-xl active:scale-95"
                        >
                            Klaim Promo
                        </button>
                    </div>
                    <div class="hidden md:block flex-shrink-0 relative z-10">
                        <img src="{{ asset('images/esteh.png') }}" class="h-72 object-contain drop-shadow-2xl floating">
                    </div>
                </div>

                <!-- Slide 2: New Menu (Mie Jebew) -->
                <div x-show="activeSlide === 2" x-transition.opacity.duration.1000ms class="absolute inset-0 bg-gradient-to-br from-[#FFB21E] to-[#E58E00] flex items-center px-12 md:px-24">
                    <div class="absolute top-0 right-0 w-1/2 h-full bg-white/10 skew-x-12 translate-x-32"></div>
                    
                    <div class="flex-1 text-dark-red relative z-10">
                        <span class="inline-block bg-dark-red text-white px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4 font-black">Must Try!</span>
                        <h2 class="text-4xl md:text-7xl font-black mb-2 leading-none drop-shadow-lg text-white">NEW <br>MIE JEBEW</h2>
                        <p class="text-lg md:text-xl font-bold opacity-90 mb-8 max-w-md">Pedasnya nampol, gurihnya dapet! Mie Jebew Ayam Saus Keju spesial.</p>
                        <button 
                            onclick="filterCategory('Mie'); document.getElementById('menu-section').scrollIntoView({behavior:'smooth'})" 
                            class="bg-dark-red text-white px-10 py-4 rounded-full font-black text-lg hover:bg-black hover:scale-110 transition shadow-xl"
                        >
                            Pesan Sekarang
                        </button>
                    </div>
                    <div class="hidden md:block flex-shrink-0 relative z-10">
                        <img src="{{ asset('images/mie_jebew.png') }}" class="h-72 object-contain drop-shadow-2xl">
                    </div>
                </div>

                <!-- Slide 3: Best Seller (Ayam Geprek) -->
                <div x-show="activeSlide === 3" x-transition.opacity.duration.1000ms class="absolute inset-0 bg-gradient-to-br from-dark-red to-[#7B0D0D] flex items-center px-12 md:px-24">
                    <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-bright-yellow/10 rounded-full blur-3xl"></div>
                    
                    <div class="flex-1 text-white relative z-10">
                        <span class="inline-block bg-bright-yellow text-dark-red px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4">Legendary Taste</span>
                        <h2 class="text-4xl md:text-7xl font-black mb-2 leading-none drop-shadow-lg">BEST <br><span class="text-bright-yellow">SELLER KIT!</span></h2>
                        <p class="text-lg md:text-xl font-medium opacity-90 mb-8 max-w-md">Paket Ayam Geprek andalan sejuta umat. Sambal merahnya juara!</p>
                        <button 
                            onclick="filterCategory('Ayam'); document.getElementById('menu-section').scrollIntoView({behavior:'smooth'})" 
                            class="bg-bright-yellow text-dark-red px-10 py-4 rounded-full font-black text-lg hover:bg-white hover:scale-110 transition shadow-xl"
                        >
                            Sikat Sekarang
                        </button>
                    </div>
                    <div class="hidden md:block flex-shrink-0 relative z-10">
                        <img src="{{ asset('images/paket_geprek.png') }}" class="h-72 object-contain drop-shadow-2xl">
                    </div>
                </div>

                <!-- Dot Indicators -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3 z-30 bg-black/20 px-4 py-2 rounded-full backdrop-blur-sm">
                    <template x-for="i in totalSlides">
                        <button 
                            @click="activeSlide = i" 
                            class="w-3 h-3 rounded-full transition-all duration-300 shadow-sm"
                            :class="activeSlide === i ? 'bg-bright-yellow w-10' : 'bg-white/50'"
                        ></button>
                    </template>
                </div>
            </div>
        </section>
    @else
        <!-- Static Hero Section (FOR GUESTS) -->
        <section class="bg-dark-red text-white px-6 py-20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[600px] h-full bg-gradient-to-l from-black/20 to-transparent skew-x-12 translate-x-32 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
                <div class="animate-in slide-in-from-left duration-1000">
                    <h1 class="text-6xl md:text-8xl font-black leading-tight tracking-tighter">
                        Berani Coba,<br>
                        <span class="text-bright-yellow">Berani Ketagihan!</span>
                    </h1>
                    <p class="mt-8 text-lg md:text-xl text-gray-200 max-w-lg leading-relaxed font-medium">
                        Rasakan sensasi ayam goreng paling renyah dengan bumbu yang meresap sampai ke tulang. Pesan sekarang dan nikmati kelezatannya!
                    </p>
                    
                    <button @click="showLogin = true" class="mt-8 bg-white text-dark-red px-10 py-4 rounded-full font-black text-lg hover:bg-bright-yellow hover:text-dark-red transition shadow-2xl transform hover:scale-110 active:scale-95">
                        Pesan Sekarang
                    </button>
                </div>
                
                <div class="hidden md:block animate-in zoom-in spin-in-2 duration-1000">
                    <img src="{{ asset('images/logo.png') }}" alt="Hayo Chicken Character" class="w-full max-w-md mx-auto brightness-110 drop-shadow-2xl">
                </div>
            </div>
        </section>
    @endauth

<!-- Category Filter -->
<div id="menu" class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-wrap items-center justify-between mb-10 gap-4">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Menu Kami</h2>
        
        <div class="flex space-x-2">
            <button onclick="filterCategory('all', this)" class="cat-btn px-6 py-2 rounded-full bg-bright-yellow text-dark-red font-bold shadow-md hover:bg-yellow-500 transition">Semua</button>
            @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category->category }}', this)" class="cat-btn px-6 py-2 rounded-full bg-white text-gray-600 font-bold border border-gray-200 hover:border-bright-yellow hover:text-dark-red transition">{{ $category->category }}</button>
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($products as $product)
        <div data-category="{{ $product->category }}" class="product-card bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-500 group border border-gray-100 flex flex-col h-full">
            <div class="relative h-64 overflow-hidden">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" 
                     alt="{{ $product->name }}" 
                     onerror="this.src='https://placehold.co/600x400?text={{ urlencode($product->name) }}'"
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
        @guest
            window.dispatchEvent(new CustomEvent('open-login'));
            return;
        @endguest

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
                image: product.image.startsWith('http') ? product.image : "{{ asset('') }}" + product.image,
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
        @guest
            window.dispatchEvent(new CustomEvent('open-login'));
            return;
        @endguest

        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const index = favorites.findIndex(f => f.id === product.id);
        const btn = document.getElementById(`fav-btn-${product.id}`);
        
        if (index > -1) {
            favorites.splice(index, 1);
            btn.classList.remove('text-red-500');
            btn.classList.add('text-gray-400');
        } else {
            favorites.push({
                id: product.id,
                name: product.name,
                category: product.category,
                price: product.price,
                image: product.image.startsWith('http') ? product.image : "{{ asset('') }}" + product.image
            });
            btn.classList.remove('text-gray-400');
            btn.classList.add('text-red-500');
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

    function filterCategory(category, element) {
        const products = document.querySelectorAll('.product-card');
        const buttons = document.querySelectorAll('.cat-btn');
        
        // Update button styles
        buttons.forEach(btn => {
            btn.classList.remove('bg-bright-yellow', 'text-dark-red');
            btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
        });
        element.classList.add('bg-bright-yellow', 'text-dark-red');
        element.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');

        // Filter products
        products.forEach(p => {
            if (category === 'all' || p.getAttribute('data-category') === category) {
                p.style.display = 'flex';
            } else {
                p.style.display = 'none';
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
