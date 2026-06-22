@extends('layouts.hayo')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <h2 class="text-3xl font-black text-dark-red mb-8 uppercase tracking-widest border-l-8 border-bright-yellow pl-4">Keamanan Akun</h2>
    
    <div class="bg-white rounded-[2rem] shadow-xl p-8 border border-gray-100">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Password Saat Ini</label>
                <input type="password" name="current_password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 focus:ring-2 focus:ring-dark-red shadow-sm transition">
                @error('current_password') <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Password Baru</label>
                <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 focus:ring-2 focus:ring-dark-red shadow-sm transition">
                @error('password') <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 focus:ring-2 focus:ring-dark-red shadow-sm transition">
            </div>

            <button type="submit" class="bg-dark-red text-white font-black px-10 py-4 rounded-full shadow-xl hover:bg-red-800 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection
