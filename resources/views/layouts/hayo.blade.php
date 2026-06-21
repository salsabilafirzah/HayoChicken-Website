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
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col" 
    x-data="{ showLogin: false, showRegister: false, cartCount: 0 }"
    x-on:open-login.window="showLogin = true"
    x-on:open-register.window="showRegister = true"
    x-on:cart-updated.window="cartCount = $event.detail.count"
    x-init="
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auth') === 'register') showRegister = true;
        
        // Auto-open if errors
        if ('{{ $errors->any() }}' && '{{ old("auth_type") }}' === 'login') showLogin = true;
        if ('{{ $errors->any() }}' && '{{ old("auth_type") }}' === 'register') showRegister = true;
        
        // Update initial cart count
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cartCount = cart.length;
    "
>

    <!-- Premium Navbar -->
    <nav class="bg-dark-red text-white py-4 px-6 sticky top-0 z-40 shadow-xl">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="h-10 flex items-center justify-center overflow-hidden transition group-hover:scale-110">
                    <img src="{{ asset('images/logo.png') }}" alt="Hayo Chicken Logo" class="h-full w-auto object-contain">
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-bright-yellow">HAYO<span class="text-white">CHICKEN</span></span>
            </a>
            
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="nav-link font-bold hover:text-bright-yellow">Menu</a>
                
                @auth
                    <a href="{{ route('favorites') }}" class="nav-link font-bold hover:text-bright-yellow">Favorit</a>
                    <a href="{{ route('cart.index') }}" class="relative nav-link font-bold hover:text-bright-yellow">
                        Keranjang
                        <span id="cart-count" x-show="cartCount > 0" class="absolute -top-2 -right-6 bg-bright-yellow text-dark-red text-[10px] font-black px-1.5 py-0.5 rounded-full border-2 border-dark-red" x-text="cartCount"></span>
                    </a>
                    
                    @if(auth()->user()->role === 'seller')
                        <a href="{{ route('admin.dashboard') }}" class="bg-bright-yellow text-dark-red px-4 py-1.5 rounded-xl font-black text-sm shadow-md">Panel Admin</a>
                    @else
                        <a href="{{ route('orders.index') }}" class="nav-link font-bold hover:text-bright-yellow">Pesanan Saya</a>
                    @endif

                    <!-- Profile Link as Text -->
                    <a href="{{ route('profile') }}" class="nav-link font-bold hover:text-bright-yellow">Profil</a>
                @else
                    <button @click="showLogin = true" class="bg-white text-dark-red px-8 py-2 rounded-full font-black hover:bg-bright-yellow hover:text-dark-red transition shadow-xl transform hover:scale-105 active:scale-95">Login</button>
                @endauth
            </div>
            
            <!-- Mobile Menu Icon -->
            <div class="md:hidden">
                <button class="text-bright-yellow focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- REAL POPUP MODAL: LOGIN -->
    <template x-if="showLogin">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 overflow-hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="showLogin = false"></div>
            
            <div class="relative w-full max-w-md animate-in zoom-in fade-in duration-300">
                <button @click="showLogin = false" class="absolute -top-12 right-0 text-white hover:text-bright-yellow transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="bg-[#F8EFDE] rounded-[3.5rem] shadow-2xl p-10 border-2 border-dark-red/20 ring-1 ring-black/5 overflow-hidden relative w-full h-[580px] flex flex-col justify-center">
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-bright-yellow/30 rounded-full blur-2xl"></div>
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-dark-red rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl border-4 border-bright-yellow">
                            <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto">
                        </div>
                        <h2 class="text-2xl font-black text-dark-red uppercase">Login Akun</h2>
                        <p class="text-gray-500 text-[10px] font-black tracking-[0.2em] mt-1 uppercase">Hayo Chicken - Pedasnya Nampol!</p>
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
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm" placeholder="email@kamu.com">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Password</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm" placeholder="********">
                        </div>
                        <button type="submit" class="w-full bg-dark-red text-white font-black py-4 rounded-2xl shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform hover:-translate-y-1 active:scale-95 text-lg mt-4">
                            Masuk Sekarang
                        </button>
                    </form>

                    <p class="text-center mt-8 text-sm text-gray-400 font-bold">
                        Belum punya akun? <button @click="showLogin = false; showRegister = true" class="text-dark-red font-black hover:underline underline-offset-4 tracking-tighter">Daftar Di Sini</button>
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
                <button @click="showRegister = false" class="absolute -top-12 right-0 text-white hover:text-bright-yellow transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="bg-[#F8EFDE] rounded-[3.5rem] shadow-2xl p-10 border-2 border-dark-red/20 ring-1 ring-black/5 overflow-hidden relative w-full h-[580px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-bright-yellow/30 rounded-full blur-2xl"></div>
                    
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-dark-red rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl border-4 border-bright-yellow">
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
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium" placeholder="Nama Kamu">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email</label>
                                <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium" placeholder="email@kamu.com">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Password</label>
                                    <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium" placeholder="********">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Ulangi</label>
                                    <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red shadow-sm font-medium" placeholder="********">
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-dark-red text-white font-black py-4 rounded-2xl shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform active:scale-95 text-lg mt-2">
                                Buat Akun
                            </button>
                        </form>
                    </div>

                    <p class="text-center mt-6 text-sm text-gray-400 font-bold border-t border-gray-100 pt-6">
                        Sudah punya akun? <button @click="showRegister = false; showLogin = true" class="text-dark-red font-black hover:underline underline-offset-4 tracking-tighter">Masuk Di Sini</button>
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
    <footer class="bg-gray-900 text-white py-16 px-6 mt-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto">
                    <span class="text-2xl font-black text-bright-yellow">HAYO CHICKEN</span>
                </div>
                <p class="text-gray-400 max-w-sm mb-8 leading-relaxed">
                    Menghadirkan kelezatan ayam goreng dengan bumbu rahasia yang meresap sampai ke tulang. Pengalaman makan tak terlupakan setiap saat.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-dark-red transition"><svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.56v14.88c0 2.48-2.02 4.56-4.56 4.56H4.56C2.02 24 0 21.92 0 19.44V4.56C0 2.02 2.02 0 4.56 0h14.88C21.98 0 24 2.02 24 4.56zM8.33 18.33V8.33h-1.66v10h1.66zm.84-11.25c0-.6-.48-1.08-1.08-1.08-.6 0-1.08.48-1.08 1.08 0 .6.48 1.08 1.08 1.08.6 0 1.08-.48 1.08-1.08zM18.33 18.33v-5.42c0-2.65-2.15-4.58-4.58-4.58-1.14 0-2.17.43-2.95 1.14V8.33H9.14v10h1.66v-5.63c0-1.74 1.4-3.14 3.14-3.14 1.74 0 3.14 1.4 3.14 3.14v5.63h1.25z"/></svg></a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition"><svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.332 2.633-1.308 3.608-.975.975-2.242 1.245-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.332-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.032-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zM12 0C8.741 0 8.333.014 7.053.072 2.695.27.27 2.69 0.072 7.053 0.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.351-.2 6.777-2.616 6.98-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-6 text-bright-yellow uppercase text-xs tracking-widest">Hayo Links</h4>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li><a href="/" class="hover:text-white transition">Menu</a></li>
                    @auth
                        <li><a href="{{ route('favorites') }}" class="hover:text-white transition">Favorit</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Keranjang</a></li>
                        @if(auth()->user()->role === 'seller')
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white transition text-bright-yellow font-bold">Panel Admin</a></li>
                        @else
                            <li><a href="{{ route('orders.index') }}" class="hover:text-white transition">Pesanan Saya</a></li>
                        @endif
                        <li><a href="{{ route('profile') }}" class="hover:text-white transition">Profil</a></li>
                    @else
                        <li><button @click="showLogin = true" class="hover:text-white transition text-left">Login / Daftar</button></li>
                    @endauth
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto border-t border-gray-800 mt-16 pt-8 text-center text-gray-500 text-xs">
            <p>&copy; 2026 Hayo Chicken Indonesia. Diolah dengan rasa sayang dan rempah pilihan.</p>
        </div>
    </footer>

    @stack('scripts')
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Already handled by Alpine x-init
        });

        function confirmLogout(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            Swal.fire({
                title: 'Keluar Akun?',
                text: "Apakah kamu yakin ingin keluar dari Hayo Chicken?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9B1A1A',
                cancelButtonColor: '#aaaaaa',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal',
                borderRadius: '2.5rem',
                customClass: {
                    popup: 'rounded-[2.5rem] shadow-2xl',
                    confirmButton: 'rounded-full px-8 py-3 font-black uppercase text-xs tracking-widest',
                    cancelButton: 'rounded-full px-8 py-3 font-black uppercase text-xs tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    @livewireScripts
</body>
</html>
