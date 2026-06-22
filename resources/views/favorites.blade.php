@extends('layouts.hayo')

@section('title', 'Menu Favorit Saya')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Menu Favorit Saya</h2>
    </div>

    <div id="favorites-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Favorites will be injected by JS -->
        <div class="col-span-full py-20 text-center bg-white rounded-3xl shadow-lg border border-gray-100">
            <p class="text-gray-400 italic">Memuat favorit...</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        renderFavorites();
    });

    function toggleFavorite(product) {
        window.toggleFavorite(product);
        // renderFavorites is called automatically by window.toggleFavorite for favorites page
    }

    function addToCart(productId, event, product) {
        window.addToCart(productId, event, product);
    }

    function renderFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const container = document.getElementById('favorites-container');
        
        if (favorites.length === 0) {
            container.innerHTML = `
                <div class="col-span-full py-20 text-center bg-white rounded-[3.5rem] shadow-2xl border border-gray-100 animate-in fade-in zoom-in duration-500">
                    <div class="w-32 h-32 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <svg class="w-16 h-16 text-red-200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <h3 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Belum Ada Favorit</h3>
                    <p class="text-gray-500 mt-3 mb-10 font-bold max-w-sm mx-auto leading-relaxed">Menu pilihanmu akan muncul di sini. Yuk, mulai jelajahi rasa yang nampol!</p>
                    <a href="/" class="inline-block bg-dark-red text-white py-5 px-12 rounded-2xl hover:bg-bright-yellow hover:text-dark-red transition shadow-2xl font-black transform hover:scale-110 active:scale-95 text-lg uppercase tracking-widest">
                        Cari Menu Sekarang
                    </a>
                </div>
            `;
            return;
        }

        let html = '';
        favorites.forEach((product) => {
            const imgSrc = product.image.startsWith('http') ? product.image : (product.image.startsWith('images/') ? "{{ asset('') }}" + product.image : "{{ asset('storage') }}/" + product.image);
            html += `
                <div class="bg-white rounded-[3rem] overflow-hidden shadow-xl hover:shadow-2xl transition duration-500 group border border-gray-100 flex flex-col h-full animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="relative h-64 overflow-hidden">
                        <img src="${imgSrc}" 
                             alt="${product.name}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        
                        <!-- Badges -->
                        <div class="absolute top-6 left-6 flex flex-col gap-2">
                            <div class="bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-sm">
                                <span class="text-[10px] font-black text-dark-red uppercase tracking-widest">${product.category}</span>
                            </div>
                        </div>

                        <!-- Favorite Toggle -->
                        <div class="absolute top-6 right-6">
                            <button id="fav-btn-${product.id}" 
                                    onclick="toggleFavorite(${JSON.stringify(product).replace(/"/g, '&quot;')})" 
                                    class="w-12 h-12 bg-white/90 backdrop-blur-md rounded-2xl flex items-center justify-center text-red-500 transition shadow-xl hover:scale-110 active:scale-90">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            </button>
                        </div>

                        <!-- Price Tag -->
                        <div class="absolute bottom-0 left-0 bg-bright-yellow text-dark-red px-8 py-3 font-black rounded-tr-[2rem] shadow-lg text-lg">
                            Rp ${new Intl.NumberFormat('id-ID').format(product.price)}
                        </div>
                    </div>
                    
                    <div class="p-10 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-black text-gray-800 mb-2 group-hover:text-dark-red transition tracking-tight">${product.name}</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">PILIHAN TERFAVORIT</p>
                        </div>
                        
                        <div class="mt-10 pt-8 border-t border-dashed border-gray-100">
                            <button onclick='addToCart(${product.id}, event, ${JSON.stringify(product).replace(/"/g, '&quot;')})' 
                                    class="w-full bg-dark-red text-white py-5 rounded-[1.5rem] hover:bg-bright-yellow hover:text-dark-red transition shadow-xl flex items-center justify-center space-x-4 group/btn transform active:scale-95">
                                <svg class="w-6 h-6 transform group-hover/btn:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                <span class="font-black uppercase tracking-widest text-xs">Tambah ke Keranjang</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        // The centralized toggleFavorite in hayo.blade.php handles icon sync
    }
</script>
@endpush
@endsection
