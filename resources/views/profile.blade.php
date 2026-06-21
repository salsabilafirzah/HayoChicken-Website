@extends('layouts.hayo')

@section('title', 'Akun Saya')

@section('content')
<div class="min-h-screen bg-bg-cream py-16 px-6" x-data="{ activeTab: 'profile' }">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-10 items-stretch">
            
            <!-- Left Sidebar -->
            <div class="lg:w-1/3 xl:w-1/4 flex">
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 ring-1 ring-black/5 flex flex-col items-center p-8 w-full h-full">
                    <!-- Profile Header -->
                    <div class="w-24 h-24 bg-dark-red rounded-3xl flex items-center justify-center text-white shadow-xl mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 mb-1 text-center truncate w-full uppercase tracking-tighter">{{ auth()->user()->name }}</h3>
                    <p class="text-xs font-bold text-gray-400 mb-8 lowercase">{{ auth()->user()->email }}</p>

                    <!-- Vertical Nav -->
                    <div class="w-full space-y-2 flex-grow">
                        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-bg-cream text-dark-red border-dark-red/10' : 'text-gray-500 hover:bg-bg-cream hover:text-dark-red'" class="w-full flex items-center space-x-4 p-4 rounded-2xl border border-transparent font-bold transition group">
                            <div :class="activeTab === 'profile' ? 'bg-dark-red text-white' : 'bg-gray-50 group-hover:bg-dark-red group-hover:text-white'" class="w-10 h-10 rounded-xl shadow-sm flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <span class="text-sm">Edit Profil</span>
                        </button>

                        <button @click="activeTab = 'password'" :class="activeTab === 'password' ? 'bg-bg-cream text-dark-red border-dark-red/10' : 'text-gray-500 hover:bg-bg-cream hover:text-dark-red'" class="w-full flex items-center space-x-4 p-4 rounded-2xl border border-transparent font-bold transition group">
                            <div :class="activeTab === 'password' ? 'bg-dark-red text-white' : 'bg-gray-50 group-hover:bg-dark-red group-hover:text-white'" class="w-10 h-10 rounded-xl flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="text-sm">Ubah Password</span>
                        </button>
                    </div>

                    <div class="w-full pt-6 mt-6 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center space-x-4 p-4 rounded-2xl text-red-400 hover:bg-red-50 hover:text-red-600 font-bold transition group">
                                <div class="w-10 h-10 bg-red-50/50 rounded-xl flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </div>
                                <span class="text-sm uppercase tracking-widest text-[10px] font-black">Keluar Akun</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="lg:flex-grow flex">
                <div class="bg-white rounded-[3rem] shadow-2xl p-10 md:p-14 border border-gray-100 ring-1 ring-black/5 w-full h-full relative overflow-hidden flex flex-col">
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-dark-red/5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 flex-grow">
                        <!-- TAB 1: EDIT PROFILE -->
                        <div x-show="activeTab === 'profile'" class="h-full flex flex-col">
                            <div class="flex items-center justify-between mb-12 border-b border-gray-100 pb-8">
                                <div>
                                    <h2 class="text-4xl font-black text-gray-800 tracking-tight">Edit Profil</h2>
                                    <p class="text-gray-400 font-bold mt-1 text-sm">Kelola informasi dasar akun Hayo Chicken kamu.</p>
                                </div>
                                <div class="hidden md:block">
                                    <span class="bg-green-50 text-green-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest border border-green-100">Akun Aktif</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-10">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="text-sm font-semibold text-gray-500 capitalize ml-1">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-gray-50 border-2 border-transparent focus:border-dark-red focus:bg-white rounded-[1.5rem] p-5 text-sm font-bold text-gray-700 transition duration-300 shadow-inner" placeholder="Masukkan nama kamu" required>
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-sm font-semibold text-gray-500 capitalize ml-1">Alamat Email</label>
                                        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-100 border-none rounded-[1.5rem] p-5 text-sm font-bold text-gray-400 cursor-not-allowed shadow-inner" disabled>
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <button type="submit" class="bg-dark-red text-white px-12 py-5 rounded-full font-black text-sm shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform hover:scale-105 active:scale-95 tracking-widest uppercase">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB 2: CHANGE PASSWORD -->
                        <div x-show="activeTab === 'password'" class="h-full flex flex-col" style="display: none;">
                            <div class="flex items-center justify-between mb-12 border-b border-gray-100 pb-8">
                                <div>
                                    <h2 class="text-4xl font-black text-gray-800 tracking-tight">Ubah Password</h2>
                                    <p class="text-gray-400 font-bold mt-1 text-sm">Ganti password kamu secara berkala demi keamanan.</p>
                                </div>
                                <div class="hidden md:block">
                                    <div class="w-12 h-12 bg-bg-cream rounded-2xl flex items-center justify-center text-dark-red shadow-inner">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('profile.password') }}" class="space-y-8 max-w-xl">
                                @csrf
                                <div class="space-y-3">
                                    <label class="text-sm font-semibold text-gray-500 capitalize ml-1">Password Saat Ini</label>
                                    <input type="password" name="current_password" required class="w-full bg-gray-50 border-2 border-transparent focus:border-dark-red focus:bg-white rounded-[1.5rem] p-5 text-sm font-bold text-gray-700 transition duration-300 shadow-inner" placeholder="••••••••">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <label class="text-sm font-semibold text-gray-500 capitalize ml-1">Password Baru</label>
                                        <input type="password" name="password" required class="w-full bg-gray-50 border-2 border-transparent focus:border-dark-red focus:bg-white rounded-[1.5rem] p-5 text-sm font-bold text-gray-700 transition duration-300 shadow-inner" placeholder="••••••••">
                                    </div>
                                    <div class="space-y-3">
                                        <label class="text-sm font-semibold text-gray-500 capitalize ml-1">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border-2 border-transparent focus:border-dark-red focus:bg-white rounded-[1.5rem] p-5 text-sm font-bold text-gray-700 transition duration-300 shadow-inner" placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <button type="submit" class="bg-dark-red text-white px-12 py-5 rounded-full font-black text-sm shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform hover:scale-105 active:scale-95 tracking-widest uppercase">
                                        Update Password Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success') || $errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            borderRadius: '2.5rem',
            confirmButtonColor: '#9B1A1A',
            customClass: {
                popup: 'rounded-[2.5rem] shadow-2xl',
                confirmButton: 'rounded-full px-8 py-3 font-black uppercase text-xs'
            }
        });
        @endif

        @if($errors->any())
        Swal.fire({
            title: 'Waduh!',
            text: "{{ $errors->first() }}",
            icon: 'error',
            borderRadius: '2.5rem',
            confirmButtonColor: '#9B1A1A',
            customClass: {
                popup: 'rounded-[2.5rem] shadow-2xl',
                confirmButton: 'rounded-full px-8 py-3 font-black uppercase text-xs'
            }
        });
        @endif
    });
</script>
@endif
@endsection
