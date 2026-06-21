<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hayo Chicken') - Premium Fried Chicken</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN (No NPM required!) -->
    <script src="https://cdn.tailwindcss.com"></script>
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
    
    </style>
    
    <style>
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #FFB21E;
        }
        .btn-primary {
            background-color: #FFB21E;
            color: #9B1A1A;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #e6a01b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 178, 30, 0.3);
        }
        .bg-dark-red {
            background-color: #9B1A1A;
        }
        .text-dark-red {
            color: #9B1A1A;
        }
        .text-bright-yellow {
            color: #FFB21E;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navbar -->
    <nav class="bg-dark-red text-white py-4 px-6 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3">
                <div class="bg-white p-1 rounded-full w-10 h-10 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/logo.png') }}" alt="Hayo Chicken Logo" class="w-full h-full object-cover">
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-bright-yellow">HAYO<span class="text-white">CHICKEN</span></span>
            </a>
            
            <div class="hidden md:flex space-x-8 font-semibold">
                <a href="/" class="nav-link">Menu</a>
                <a href="/favorites" class="nav-link">Favorit</a>
                <a href="/cart" class="nav-link flex items-center">
                    Keranjang
                    <span id="cart-count" class="ml-2 bg-bright-yellow text-dark-red text-xs px-2 py-0.5 rounded-full">0</span>
                </a>
                @auth
                    @if(auth()->user()->role === 'seller')
                        <a href="/admin/dashboard" class="nav-link">Admin Panel</a>
                    @else
                        <a href="/orders" class="nav-link">Pesanan Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="nav-link uppercase text-xs">Logout</button>
                    </form>
                @else
                    <a href="/login" class="nav-link">Login</a>
                @endauth
            </div>
            
            <div class="md:hidden">
                <!-- Mobile menu button -->
                <button class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-red text-white py-12 px-6 mt-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <h3 class="text-2xl font-bold text-bright-yellow mb-4">HAYO CHICKEN</h3>
                <p class="text-gray-300">Nikmati kelezatan ayam goreng krispi terbaik dengan resep rahasia yang bikin nagih. Berani Coba, Berani Ketagihan!</p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="/" class="hover:text-bright-yellow transition">Menu Utama</a></li>
                    <li><a href="#" class="hover:text-bright-yellow transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-bright-yellow transition">Lokasi Outlet</a></li>
                    <li><a href="#" class="hover:text-bright-yellow transition">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Hubungi Kami</h4>
                <p class="text-gray-300">Email: halo@hayochicken.com</p>
                <p class="text-gray-300">Phone: +62 812 3456 7890</p>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-bright-yellow hover:text-dark-red transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto border-t border-white/10 mt-12 pt-8 text-center text-gray-400 text-sm">
            &copy; 2026 Hayo Chicken. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.innerText = cart.length;
        });
    </script>
</body>
</html>
