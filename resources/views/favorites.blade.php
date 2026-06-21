@extends('layouts.hayo')

@section('title', 'Menu Favorit Saya')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Menu Favorit Saya</h2>
        <a href="/" class="text-dark-red font-bold hover:underline">← Kembali ke Menu</a>
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

    function renderFavorites() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const container = document.getElementById('favorites-container');
        
        if (favorites.length === 0) {
            container.innerHTML = `
                <div class="col-span-full py-20 text-center bg-white rounded-3xl shadow-lg border border-gray-100">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-red-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Belum Ada Favorit</h3>
                    <p class="text-gray-400 mt-2 mb-6">Kamu belum menyukai menu apapun. Yuk, jelajahi menu lezat kami!</p>
                    <a href="/" class="btn-primary inline-block">Cari Menu Lezat</a>
                </div>
            `;
            return;
        }

        let html = '';
        favorites.forEach((product) => {
            html += `
                <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-500 group border border-gray-100 flex flex-col h-full">
                    <div class="relative h-64 overflow-hidden">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 right-4">
                            <button onclick="toggleFavorite(${JSON.stringify(product).replace(/"/g, '&quot;')})" class="w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-red-500 transition shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            </button>
                        </div>
                        <div class="absolute bottom-0 left-0 bg-bright-yellow text-dark-red px-6 py-2 font-black rounded-tr-3xl shadow-lg">
                            Rp ${new Intl.NumberFormat('id-ID').format(product.price)}
                        </div>
                    </div>
                    
                    <div class="p-8 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">${product.category}</span>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-dark-red transition">${product.name}</h3>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                            <button onclick="addToCart(${product.id})" class="bg-dark-red text-white py-3 px-6 rounded-2xl hover:bg-red-800 transition shadow-lg flex-grow font-bold">
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function toggleFavorite(product) {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const index = favorites.findIndex(f => f.id === product.id);
        
        if (index > -1) {
            favorites.splice(index, 1);
        } else {
            favorites.push(product);
        }
        
        localStorage.setItem('favorites', JSON.stringify(favorites));
        renderFavorites();
    }
</script>
@endpush
@endsection
