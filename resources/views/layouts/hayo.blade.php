<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayo Chicken - @yield('title', 'Lezat & Renyah')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-red': '#9B1A1A',
                        'bg-cream': '#F9F4EB',
                        'bright-yellow': '#FFB21E',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #F9F4EB;
            font-family: 'Inter', sans-serif;
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .btn-primary {
            @apply bg-bright-yellow text-dark-red font-black px-8 py-3 rounded-full hover:bg-yellow-500 transition shadow-lg inline-block transform hover:scale-105;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #9B1A1A33;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9B1A1A66;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col" x-data="{ showLogin: false, showRegister: false, cartCount: 0 }"
    x-on:open-login.window="showLogin = true" x-on:open-register.window="showRegister = true"
    x-on:cart-updated.window="cartCount = $event.detail.count" x-init="
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auth') === 'register') showRegister = true;
        
        // Auto-open if errors
        if ('{{ $errors->any() }}' && '{{ old("auth_type") }}' === 'login') showLogin = true;
        if ('{{ $errors->any() }}' && '{{ old("auth_type") }}' === 'register') showRegister = true;
        
        // Update initial cart count
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cartCount = cart.length;
    ">

    <!-- Premium Navbar -->
    <nav class="bg-dark-red text-white py-4 px-6 sticky top-0 z-40 shadow-xl">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="h-10 flex items-center justify-center overflow-hidden transition group-hover:scale-110">
                    <img src="{{ asset('images/logo.png') }}" alt="Hayo Chicken Logo"
                        class="h-full w-auto object-contain">
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-bright-yellow">HAYO<span
                        class="text-white">CHICKEN</span></span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="nav-link font-bold hover:text-bright-yellow">Menu</a>

                @auth
                    <a href="{{ route('favorites') }}" class="nav-link font-bold hover:text-bright-yellow">Favorit</a>
                    <a href="{{ route('cart.index') }}" class="relative nav-link font-bold hover:text-bright-yellow">
                        Keranjang
                        <span id="cart-count" x-show="cartCount > 0"
                            class="absolute -top-2 -right-6 bg-bright-yellow text-dark-red text-[10px] font-black px-1.5 py-0.5 rounded-full border-2 border-dark-red"
                            x-text="cartCount"></span>
                    </a>

                    @if(auth()->user()->role === 'seller')
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-bright-yellow text-dark-red px-4 py-1.5 rounded-xl font-black text-sm shadow-md">Panel
                            Admin</a>
                    @else
                        <a href="{{ route('orders.index') }}" class="nav-link font-bold hover:text-bright-yellow">Pesanan
                            Saya</a>
                    @endif

                    <!-- Profile Link as Text -->
                    <a href="{{ route('profile') }}" class="nav-link font-bold hover:text-bright-yellow">Profil</a>
                @else
                    <button @click="showLogin = true"
                        class="bg-white text-dark-red px-8 py-2 rounded-full font-black hover:bg-bright-yellow hover:text-dark-red transition shadow-xl transform hover:scale-105 active:scale-95">Login</button>
                @endauth
            </div>

            <!-- Mobile Menu Icon -->
            <div class="md:hidden">
                <button class="text-bright-yellow focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- REAL POPUP MODAL: LOGIN -->
    <template x-if="showLogin">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 overflow-hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="showLogin = false"></div>

            <div class="relative w-full max-w-md animate-in zoom-in fade-in duration-300">
                <button @click="showLogin = false"
                    class="absolute -top-12 right-0 text-white hover:text-bright-yellow transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div
                    class="bg-[#F8EFDE] rounded-[3.5rem] shadow-2xl p-10 border-2 border-dark-red/20 ring-1 ring-black/5 overflow-hidden relative w-full h-[580px] flex flex-col justify-center">
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-bright-yellow/30 rounded-full blur-2xl"></div>
                    <div class="text-center mb-8">
                        <div
                            class="w-20 h-20 bg-dark-red rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl border-4 border-bright-yellow">
                            <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto">
                        </div>
                        <h2 class="text-2xl font-black text-dark-red uppercase">Login Akun</h2>
                        <p class="text-gray-500 text-[10px] font-black tracking-[0.2em] mt-1 uppercase">Hayo Chicken -
                            Pedasnya Nampol!</p>
                    </div>

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="auth_type" value="login">

                        @if($errors->any() && old('auth_type') === 'login')
                            <div class="bg-red-50 text-red-500 p-3 rounded-xl text-[10px] font-bold mt-2">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="space-y-1">
                            <label
                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm"
                                placeholder="email@kamu.com">
                        </div>
                        <div class="space-y-1">
                            <label
                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Password</label>
                            <input type="password" name="password" required
                                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm"
                                placeholder="********">
                        </div>
                        <button type="submit"
                            class="w-full bg-dark-red text-white font-black py-4 rounded-2xl shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform hover:-translate-y-1 active:scale-95 text-lg mt-4">
                            Masuk Sekarang
                        </button>
                    </form>

                    <p class="text-center mt-8 text-sm text-gray-400 font-bold">
                        Belum punya akun? <button @click="showLogin = false; showRegister = true"
                            class="text-dark-red font-black hover:underline underline-offset-4 tracking-tighter">Daftar
                            Di Sini</button>
                    </p>
                </div>
            </div>
        </div>
    </template>

    <!-- REAL POPUP MODAL: REGISTER -->
    <template x-if="showRegister">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 overflow-hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="showRegister = false"></div>

            <div class="relative w-full max-w-md animate-in zoom-in fade-in duration-300">
                <button @click="showRegister = false"
                    class="absolute -top-12 right-0 text-white hover:text-bright-yellow transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div
                    class="bg-[#F8EFDE] rounded-[3.5rem] shadow-2xl p-10 border-2 border-dark-red/20 ring-1 ring-black/5 overflow-hidden relative w-full h-[580px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-bright-yellow/30 rounded-full blur-2xl"></div>

                    <div class="text-center mb-6">
                        <div
                            class="w-20 h-20 bg-dark-red rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl border-4 border-bright-yellow">
                            <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto">
                        </div>
                        <h2 class="text-2xl font-black text-dark-red uppercase">Daftar Akun</h2>
                    </div>

                    <div class="overflow-y-auto pr-1 flex-grow custom-scrollbar">
                        <form method="POST" action="{{ route('register.store') }}" class="space-y-4 px-1">
                            @csrf
                            <input type="hidden" name="auth_type" value="register">

                            @if($errors->any() && old('auth_type') === 'register')
                                <div class="bg-red-50 text-red-500 p-3 rounded-xl text-[10px] font-bold mb-4">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama
                                    Lengkap</label>
                                <input type="text" name="name" required
                                    class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium"
                                    placeholder="Nama Kamu">
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email</label>
                                <input type="email" name="email" required
                                    class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium"
                                    placeholder="email@kamu.com">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Password</label>
                                    <input type="password" name="password" required
                                        class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium"
                                        placeholder="********">
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Ulangi</label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium"
                                        placeholder="********">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-dark-red text-white font-black py-4 rounded-2xl shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform active:scale-95 text-lg mt-2">
                                Buat Akun
                            </button>
                        </form>
                    </div>

                    <p class="text-center mt-6 text-sm text-gray-400 font-bold border-t border-gray-100 pt-6">
                        Sudah punya akun? <button @click="showRegister = false; showLogin = true"
                            class="text-dark-red font-black hover:underline underline-offset-4 tracking-tighter">Masuk
                            Di Sini</button>
                    </p>
                </div>
            </div>
        </div>
    </template>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="bg-gradient-to-b from-dark-red to-[#7B0D0D] text-white py-16 px-6 mt-12 relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-bright-yellow/5 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-64 h-64 bg-black/20 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
            <!-- Brand Section -->
            <div class="md:col-span-2 pr-0 md:pr-12">
                <div class="flex items-center space-x-3 mb-6 group cursor-pointer w-max">
                    <div class="p-2 bg-white/10 rounded-xl group-hover:bg-bright-yellow transition duration-300">
                        <img src="{{ asset('images/logo.png') }}"
                            class="h-8 w-auto transform group-hover:-rotate-12 group-hover:scale-110 transition duration-300 drop-shadow-md">
                    </div>
                    <span
                        class="text-2xl font-black text-bright-yellow tracking-tight group-hover:text-white transition duration-300">HAYO
                        CHICKEN</span>
                </div>
                <p class="text-white/80 max-w-sm mb-8 leading-relaxed font-medium">
                    Menghadirkan kelezatan ayam goreng dengan bumbu rahasia yang meresap sampai ke tulang. Pengalaman
                    makan tak terlupakan setiap saat.
                </p>
                <!-- Social Icons -->
                <div class="flex space-x-4">
                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-bright-yellow hover:text-dark-red transition duration-300 transform hover:-translate-y-1 shadow-lg cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                        class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-bright-yellow hover:text-dark-red transition duration-300 transform hover:-translate-y-1 shadow-lg cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Links Group 1 -->
            <div>
                <h4 class="font-black mb-6 text-bright-yellow flex items-center space-x-2">
                    <span class="w-2 h-2 bg-bright-yellow rounded-full"></span>
                    <span class="uppercase text-xs tracking-widest">Hayo Links</span>
                </h4>
                <ul class="space-y-4 text-white/70 text-sm font-medium">
                    <li><a href="/"
                            class="hover:text-bright-yellow hover:translate-x-2 inline-block transition duration-300">Menu
                            Utama</a></li>
                    @auth
                        <li><a href="{{ route('favorites') }}"
                                class="hover:text-bright-yellow hover:translate-x-2 inline-block transition duration-300">Favorit
                                Tersimpan</a></li>
                        <li><a href="{{ route('cart.index') }}"
                                class="hover:text-bright-yellow hover:translate-x-2 inline-block transition duration-300">Lihat
                                Keranjang</a></li>
                        @if(auth()->user()->role === 'seller')
                            <li><a href="{{ route('admin.dashboard') }}"
                                    class="hover:text-white transition text-bright-yellow hover:translate-x-2 inline-block duration-300 font-bold">Panel
                                    Admin</a></li>
                        @else
                            <li><a href="{{ route('orders.index') }}"
                                    class="hover:text-bright-yellow hover:translate-x-2 inline-block transition duration-300">Pesanan
                                    Saya</a></li>
                        @endif
                        <li><a href="{{ route('profile') }}"
                                class="hover:text-bright-yellow hover:translate-x-2 inline-block transition duration-300">Profil
                                Saya</a></li>
                    @else
                        <li><button @click="showLogin = true"
                                class="hover:text-bright-yellow hover:translate-x-2 inline-block transition duration-300 text-left">Login
                                / Daftar</button></li>
                    @endauth
                </ul>
            </div>

            <!-- Kontak Kami -->
            <div>
                <h4 class="font-black mb-6 text-bright-yellow flex items-center space-x-2">
                    <span class="w-2 h-2 bg-bright-yellow rounded-full"></span>
                    <span class="uppercase text-xs tracking-widest">Kontak & Lokasi</span>
                </h4>
                <ul class="space-y-5 text-white/70 text-sm font-medium">
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-bright-yellow mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="leading-relaxed">Jl. Mayjend Sungkono, Blater,<br>Purbalingga</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-bright-yellow flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>085601194181</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-bright-yellow flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Buka Setiap Hari: 10:00 - 22:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div
            class="max-w-7xl mx-auto border-t border-white/10 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center text-white/50 text-xs font-medium relative z-10">
            <p>&copy; 2026 Hayo Chicken Indonesia. Diolah dengan rasa sayang dan rempah pilihan.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <span class="cursor-default">Privasi</span>
                <span class="cursor-default">Syarat & Ketentuan</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function addToCart(productId, event, productData = null) {
            @guest
                window.dispatchEvent(new CustomEvent('open-login'));
                return;
            @endguest

            let product = null;
            if (productData) {
                product = productData;
            } else {
                // If on home page, products are in a global variable
                if (window.allProducts) {
                    product = window.allProducts.find(p => p.id === productId);
                }
            }

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
                    image: product.image.startsWith('http') ? product.image : (product.image.startsWith('images/') ? "{{ asset('') }}" + product.image : "{{ asset('storage') }}/" + product.image),
                    qty: 1
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            // Visual feedback
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';

            setTimeout(() => {
                btn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
                btn.classList.replace('bg-dark-red', 'bg-green-500');

                const cartCount = document.getElementById('cart-count');
                if (cartCount) cartCount.innerText = cart.length;
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: cart.length } }));

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
                if (btn) {
                    btn.classList.remove('text-red-500');
                    btn.classList.add('text-gray-400');
                }
            } else {
                favorites.push({
                    id: product.id,
                    name: product.name,
                    category: product.category,
                    price: product.price,
                    image: product.image
                });
                if (btn) {
                    btn.classList.remove('text-gray-400');
                    btn.classList.add('text-red-500');
                }
            }

            localStorage.setItem('favorites', JSON.stringify(favorites));

            // If on favorites page, re-render
            if (window.location.pathname.includes('favorites')) {
                if (typeof renderFavorites === 'function') renderFavorites();
            }
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

        function confirmLogout(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: 'Keluar Akun?',
                text: "Apakah kamu yakin ingin keluar dari Hayo Chicken?",
                iconHtml: '<svg class="w-16 h-16 text-dark-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>',
                showCancelButton: true,
                confirmButtonColor: '#9B1A1A',
                cancelButtonColor: '#aaaaaa',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal',
                borderRadius: '2.5rem',
                customClass: {
                    popup: 'rounded-[2.5rem] shadow-2xl p-8',
                    confirmButton: 'rounded-full px-8 py-3 font-black uppercase text-xs tracking-widest',
                    cancelButton: 'rounded-full px-8 py-3 font-black uppercase text-xs tracking-widest',
                    icon: 'border-none'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>