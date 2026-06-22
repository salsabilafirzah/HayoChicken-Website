<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Hayo Chicken</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-red': '#9B1A1A',
                        'bright-yellow': '#FFB21E',
                        'admin-bg': '#F9F4EB',
                        'soft-cream': '#F8EFDE',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #9B1A1A33; border-radius: 10px; }
        
        .sidebar-link.active {
            @apply bg-bright-yellow text-dark-red shadow-lg shadow-bright-yellow/20;
        }
        .sidebar-link.active svg {
            @apply text-dark-red;
        }
    </style>
</head>
<body class="bg-admin-bg text-slate-700 min-h-screen flex" x-data="{ sidebarOpen: true }">

    <!-- Sidebar -->
    <aside 
        class="bg-white/80 backdrop-blur-md border-r border-dark-red/5 w-72 flex-shrink-0 flex flex-col transition-all duration-300 z-50 fixed inset-y-0 left-0 lg:relative"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'"
    >
        <!-- Logo -->
        <div class="h-24 flex items-center px-6 border-b border-dark-red/5 flex-shrink-0 overflow-hidden">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-dark-red rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-dark-red/20">
                    <img src="{{ asset('images/logo.png') }}" class="w-6 h-6 object-contain">
                </div>
                <span class="text-xl font-extrabold tracking-tight text-dark-red uppercase" x-show="sidebarOpen">Hayo<span class="text-bright-yellow">Admin</span></span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-grow p-4 space-y-2 overflow-y-auto custom-scrollbar">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] px-2 mb-4" x-show="sidebarOpen">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center p-3 rounded-2xl transition group {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-500 hover:bg-slate-50' }}">
                <div class="w-6 flex justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <span class="ml-3 font-semibold" x-show="sidebarOpen">Dashboard Analitik</span>
            </a>

            <a href="{{ route('admin.orders') }}" class="sidebar-link flex items-center p-3 rounded-2xl transition group {{ request()->routeIs('admin.orders') ? 'active' : 'text-slate-500 hover:bg-slate-50' }}">
                <div class="w-6 flex justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="ml-3 font-semibold" x-show="sidebarOpen">Kelola Pesanan</span>
            </a>

            <a href="{{ route('admin.products') }}" class="sidebar-link flex items-center p-3 rounded-2xl transition group {{ request()->routeIs('admin.products') ? 'active' : 'text-slate-500 hover:bg-slate-50' }}">
                <div class="w-6 flex justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                <span class="ml-3 font-semibold" x-show="sidebarOpen">Kelola Menu</span>
            </a>

            <div class="pt-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-4" x-show="sidebarOpen">Sistem</p>
                
                <a href="{{ route('home') }}" class="sidebar-link flex items-center p-3 mx-2 rounded-2xl transition group text-slate-500 hover:bg-bright-yellow/10">
                    <div class="w-6 flex justify-center">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-dark-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <span class="ml-3 font-bold" x-show="sidebarOpen">Halaman Utama</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirmLogout(event)">
                    @csrf
                    <button type="submit" class="w-full sidebar-link flex items-center p-3 mx-2 rounded-2xl transition group text-red-500 hover:bg-red-50 mt-2">
                        <div class="w-6 flex justify-center">
                            <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <span class="ml-3 font-extrabold" x-show="sidebarOpen">Keluar Akun</span>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Profile Bar Mini -->
        <div class="p-4 border-t border-slate-100 mt-auto" x-show="sidebarOpen">
            <div class="bg-slate-50 rounded-2xl p-3 flex items-center space-x-3">
                <div class="w-10 h-10 bg-dark-red rounded-xl flex items-center justify-center text-white font-black">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 uppercase tracking-tighter">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col min-w-0 h-screen overflow-hidden">
        <!-- Top Bar -->
        <header class="h-24 bg-white/40 backdrop-blur-md border-b border-dark-red/5 flex items-center justify-between px-8 flex-shrink-0">
            <div class="flex items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-dark-red transition mr-6 p-2 hover:bg-bright-yellow/10 rounded-xl">
                    <svg class="w-6 h-6 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <h1 class="text-2xl font-black text-dark-red tracking-tighter">@yield('page_title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center space-x-4">
                <div class="px-5 py-2 bg-bright-yellow text-dark-red rounded-full flex items-center shadow-lg shadow-bright-yellow/20">
                    <div class="w-2.5 h-2.5 rounded-full bg-dark-red animate-pulse mr-2.5"></div>
                    <span class="text-[10px] font-black tracking-widest uppercase">Sistem Aktif</span>
                </div>
            </div>
        </header>

        <!-- Scrollable Area -->
        <div class="flex-grow overflow-y-auto p-8 custom-scrollbar">
            @yield('content')
        </div>
    </main>

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            const form = event.target;
            
            Swal.fire({
                title: 'Keluar Panel Admin?',
                text: "Kamu akan dialihkan ke halaman utama.",
                iconHtml: '<svg class="w-16 h-16 text-dark-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>',
                showCancelButton: true,
                confirmButtonColor: '#9B1A1A',
                cancelButtonColor: '#CBD5E1',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                borderRadius: '1.5rem',
                customClass: {
                    popup: 'rounded-[2rem] shadow-2xl p-8',
                    confirmButton: 'rounded-xl px-8 py-3 font-bold',
                    cancelButton: 'rounded-xl px-8 py-3 font-bold text-slate-600',
                    icon: 'border-none'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                borderRadius: '1.5rem',
                customClass: {
                    popup: 'rounded-[1.5rem] shadow-2xl',
                }
            });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
