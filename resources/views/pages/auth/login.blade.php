@extends('layouts.auth_hayo')

@section('content')
<div class="flex flex-col gap-8">
    <div class="text-center">
        <h2 class="text-2xl font-black text-gray-800">Selamat Datang!</h2>
        <p class="text-gray-400 text-sm mt-1">Silakan masuk ke akun Hayo Chicken kamu</p>
    </div>

    @if (session('status'))
        <div class="bg-green-50 text-green-600 p-4 rounded-2xl text-sm font-medium border border-green-100 italic">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Alamat Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                placeholder="nama@email.com"
                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-dark-red transition shadow-sm"
            >
            @error('email')
                <p class="text-red-500 text-xs mt-1 italic font-medium ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center px-1">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-dark-red uppercase tracking-widest hover:underline">Lupa Password?</a>
                @endif
            </div>
            <input 
                type="password" 
                name="password" 
                required 
                placeholder="Masukkan kata sandi..."
                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-dark-red transition shadow-sm"
            >
            @error('password')
                <p class="text-red-500 text-xs mt-1 italic font-medium ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <label class="flex items-center space-x-3 cursor-pointer group w-fit ml-1">
            <div class="relative">
                <input type="checkbox" name="remember" class="sr-only peer">
                <div class="w-5 h-5 bg-gray-100 rounded-md border-2 border-gray-200 peer-checked:bg-dark-red peer-checked:border-dark-red transition shadow-sm"></div>
                <svg class="absolute top-0 left-0 w-5 h-5 text-white scale-0 peer-checked:scale-75 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 group-hover:text-dark-red transition">Biarkan saya tetap masuk</span>
        </label>

        <button type="submit" class="w-full bg-dark-red text-white font-black py-4 rounded-2xl shadow-xl hover:bg-red-800 transition transform hover:-translate-y-1 active:scale-95 text-lg">
            Masuk Sekarang
        </button>
    </form>

    <div class="pt-6 border-t border-gray-50 text-center">
        <p class="text-gray-400 text-sm">Belum punya akun?</p>
        <a href="{{ route('register') }}" class="inline-block mt-2 text-dark-red font-black text-lg hover:underline transition">Daftar Akun Baru</a>
    </div>
</div>
@endsection
