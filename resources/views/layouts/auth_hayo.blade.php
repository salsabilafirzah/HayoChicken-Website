<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayo Chicken - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
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
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Fake Home Page Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-dark-red opacity-90"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-bright-yellow opacity-20 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-bright-yellow opacity-10 rounded-full blur-[120px] -ml-40 -mb-40"></div>
        <!-- Blurred Content Simulation -->
        <div class="absolute inset-0 flex flex-col p-20 opacity-20 blur-sm">
            <div class="h-20 w-64 bg-white/20 rounded-full mb-20"></div>
            <div class="h-32 w-full max-w-2xl bg-white/20 rounded-3xl mb-8"></div>
            <div class="h-8 w-96 bg-white/20 rounded-full"></div>
        </div>
    </div>

    <!-- Backdrop Blur Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-md z-10"></div>

    <div class="max-w-md w-full relative z-20 transform animate-in fade-in zoom-in duration-500">
        <!-- Close Button -->
        <a href="/" class="absolute -top-16 right-0 text-white/50 hover:text-white transition flex items-center space-x-2 group">
            <span class="text-xs font-bold uppercase tracking-widest opacity-0 group-hover:opacity-100 transition">Tutup</span>
            <div class="w-10 h-10 border border-white/20 rounded-full flex items-center justify-center group-hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
        </a>

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-block">
                <img src="{{ asset('images/logo.png') }}" alt="Hayo Chicken Logo" class="h-20 w-auto mx-auto mb-2 drop-shadow-2xl">
                <h1 class="text-2xl font-black text-white tracking-tighter">HAYO<span class="text-bright-yellow">CHICKEN</span></h1>
            </div>
        </div>

        <!-- Auth Card (The "Popup") -->
        <div class="bg-white/95 backdrop-blur-xl rounded-[3rem] shadow-[0_35px_60px_-15px_rgba(0,0,0,0.5)] p-10 border border-white/20 relative overflow-hidden">
            <!-- Decoration -->
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-bright-yellow/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-dark-red/10 rounded-full blur-2xl"></div>

            @yield('content')
        </div>

        <!-- Footer Link -->
        <div class="text-center mt-8">
            <a href="/" class="text-gray-400 hover:text-dark-red transition text-sm font-bold uppercase tracking-widest">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
