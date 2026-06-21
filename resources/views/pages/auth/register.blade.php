@extends('layouts.auth_hayo')

@section('content')
<div class="flex flex-col gap-6">
    <div class="text-center">
        <h2 class="text-2xl font-black text-gray-800">Daftar Akun Baru</h2>
        <p class="text-gray-400 text-sm mt-1">Gabung jadi keluarga Hayo Chicken!</p>
    </div>

    <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                placeholder="Masukkan nama lengkap kamu..."
                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-dark-red transition shadow-sm"
            >
            @error('name')
                <p class="text-red-500 text-[10px] mt-1 italic font-medium ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Alamat Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                placeholder="nama@email.com"
                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-dark-red transition shadow-sm"
            >
            @error('email')
                <p class="text-red-500 text-[10px] mt-1 italic font-medium ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Buat Kata Sandi</label>
            <input 
                type="password" 
                name="password" 
                required 
                placeholder="Minimal 8 karakter..."
                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-dark-red transition shadow-sm"
            >
            @error('password')
                <p class="text-red-500 text-[10px] mt-1 italic font-medium ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Ulangi Kata Sandi</label>
            <input 
                type="password" 
                name="password_confirmation" 
                required 
                placeholder="Masukkan kembali kata sandi..."
                class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-dark-red transition shadow-sm"
            >
        </div>

        <button type="submit" class="w-full bg-dark-red text-white font-black py-4 rounded-2xl shadow-xl hover:bg-red-800 transition transform hover:-translate-y-1 active:scale-95 text-lg mt-2">
            Buat Akun Sekarang
        </button>
    </form>

    <div class="pt-6 border-t border-gray-50 text-center">
        <p class="text-gray-400 text-sm">Sudah punya akun?</p>
        <a href="{{ route('login') }}" class="inline-block mt-2 text-dark-red font-black text-lg hover:underline transition">Masuk ke Akun</a>
    </div>
</div>
@endsection
