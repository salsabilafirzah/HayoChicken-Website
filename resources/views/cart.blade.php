@extends('layouts.hayo')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Keranjang Belanja</h2>
    </div>

    <div class="max-w-5xl mx-auto flex flex-col gap-10">
        <!-- Cart Items (Top Section) -->
        <div class="w-full">
            <div id="cart-items" class="space-y-4">
                <!-- Items will be injected by JS -->
                <div class="text-center py-20 bg-white rounded-3xl shadow-lg border border-gray-100 italic text-gray-400">
                    Memuat keranjang...
                </div>
            </div>
        </div>

        <!-- Checkout Section (Bottom Section) -->
        <div id="checkout-section" class="w-full">
            <div class="bg-white rounded-[3.5rem] shadow-2xl border border-gray-100 p-10 md:p-14 relative overflow-hidden ring-1 ring-black/5">
                <!-- Decorative element -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-dark-red/5 rounded-full blur-3xl"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    <!-- Left Side: Order Summary -->
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 mb-8 flex items-center">
                            <span class="w-2 h-8 bg-bright-yellow rounded-full mr-4"></span>
                            Ringkasan Pesanan
                        </h3>
                        
                        <div class="space-y-6 bg-bg-cream p-8 rounded-[2.5rem] border border-dark-red/5 shadow-inner">
                            <div class="flex justify-between text-gray-500 font-bold text-xs tracking-widest">
                                <span>Subtotal</span>
                                <span id="subtotal" class="text-gray-800">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-gray-500 font-bold text-xs tracking-widest border-b border-gray-200 pb-6">
                                <span>Ongkos Kirim</span>
                                <span class="text-green-500 font-black">Gratis</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-xl font-black text-gray-400 tracking-tighter">Total Tagihan</span>
                                <span id="total" class="text-4xl font-black text-dark-red tracking-tighter">Rp 0</span>
                            </div>
                        </div>

                        <div class="mt-8 p-6 bg-blue-50/50 backdrop-blur-sm rounded-[2.5rem] border border-blue-100 shadow-inner">
                            <div class="flex items-center space-x-6">
                                <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-200">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-xs font-semibold text-blue-600 leading-relaxed">
                                    Pesanan kamu akan diproses kilat setelah pembayaran dikonfirmasi oleh tim Hayo Chicken!
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Logistics & Payment -->
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 mb-8 flex items-center">
                            <span class="w-2 h-8 bg-dark-red rounded-full mr-4"></span>
                            Data Pengiriman
                        </h3>

                        @auth
                        <form id="checkout-form" class="space-y-6" x-data="{ payment: 'cash' }" enctype="multipart/form-data">
                            <div>
                                <label class="text-xs font-semibold text-gray-400 mb-3 block">Alamat Lengkap</label>
                                <textarea name="delivery_address" id="delivery_address" rows="3" class="w-full bg-gray-50 border-none rounded-2xl p-6 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-dark-red/20 transition resize-none custom-scrollbar shadow-inner" placeholder="Contoh: Jl. Mawar No. 10..." required>{{ auth()->user()->address ?? '' }}</textarea>
                            </div>
                            
                            <div class="relative group">
                                <label class="text-xs font-semibold text-gray-400 mb-3 block">Metode Pembayaran</label>
                                <div class="relative">
                                    <select name="payment_method" id="payment_method" x-model="payment" class="w-full bg-gray-50 border-none rounded-2xl p-6 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-dark-red/20 transition appearance-none cursor-pointer shadow-inner pr-12">
                                        <option value="cash">Bayar di Tempat (COD)</option>
                                        <option value="qris">Pembayaran via QRIS</option>
                                    </select>
                                    <!-- Custom Arrow Icon -->
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Pure Text QRIS & Upload Section -->
                            <div x-show="payment === 'qris'" x-transition class="bg-white rounded-[2rem] text-center space-y-6 shadow-xl border border-gray-100 overflow-hidden">
                                <div class="bg-dark-red py-3">
                                    <p class="text-xs font-black text-white">1. Scan Pembayaran</p>
                                </div>
                                <div class="px-8 pb-8 space-y-6">
                                    <img src="{{ asset('images/qris_hayo.jpeg') }}" class="w-52 h-auto mx-auto rounded-2xl shadow-sm border border-gray-50">
                                    
                                    <div class="text-left space-y-3" x-data="{ fileName: '' }">
                                        <label class="text-xs font-semibold text-gray-400 text-center block">2. Upload Bukti Transfer</label>
                                        <div class="relative">
                                            <input type="file" name="payment_receipt" @change="fileName = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div :class="fileName ? 'bg-bg-cream border-dark-red shadow-md' : 'bg-gray-50 border-gray-300 border-dashed hover:border-dark-red/50 hover:bg-white'" class="border-2 rounded-2xl p-6 text-center transition-all duration-300 cursor-pointer group-hover:scale-[1.02]">
                                                <p class="text-sm font-semibold tracking-tight" :class="fileName ? 'text-dark-red' : 'text-gray-400 group-hover:text-dark-red'" x-text="fileName ? fileName : 'Klik untuk pilih foto'"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="checkout-btn" class="w-full bg-dark-red text-white py-6 rounded-3xl font-black text-lg shadow-xl hover:bg-bright-yellow hover:text-dark-red transition transform hover:scale-105 active:scale-95 flex items-center justify-center space-x-3 tracking-tight">
                                <span>Buat Pesanan Sekarang</span>
                            </button>
                        </form>
                        @else
                        <div class="h-full flex flex-col items-center justify-center p-10 bg-gray-50 rounded-[2.5rem] border border-dashed border-gray-200 text-center">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <p class="text-gray-500 font-bold mb-6">Ups! Kamu harus login dulu untuk memesan.</p>
                            <button @click="showLogin = true" class="bg-dark-red text-white px-12 py-4 rounded-full font-black shadow-xl hover:scale-105 transition">Login Sekarang</button>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        renderCart();
        
        const form = document.getElementById('checkout-form');
        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                if (cart.length === 0) {
                    alert('Keranjang Anda kosong!');
                    return;
                }

                const btn = document.getElementById('checkout-btn');
                btn.disabled = true;
                btn.innerHTML = '<span>Memproses...</span>';

                const formData = new FormData(form);
                formData.append('items', JSON.stringify(cart));

                try {
                    const response = await fetch('{{ route("orders.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    if (result.success) {
                        localStorage.removeItem('cart');
                        window.location.href = result.redirect;
                    } else {
                        alert('Gagal membuat pesanan.');
                        btn.disabled = false;
                        btn.innerHTML = '<span>Buat Pesanan Sekarang</span>';
                    }
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan.');
                    btn.disabled = false;
                    btn.innerHTML = '<span>Buat Pesanan Sekarang</span>';
                }
            });
        }
    });

    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const container = document.getElementById('cart-items');
        const checkoutSection = document.getElementById('checkout-section');
        
        if (cart.length === 0) {
            if (checkoutSection) checkoutSection.style.display = 'none';
            container.innerHTML = `
                <div class="col-span-full py-20 text-center bg-white rounded-3xl shadow-lg border border-gray-100 flex flex-col items-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Keranjang Kosong</h3>
                    <p class="text-gray-400 mt-2 mb-6">Menu favorit kamu menunggu untuk dipilih!</p>
                    <a href="/" class="inline-block bg-dark-red text-white py-4 px-10 rounded-full hover:bg-bright-yellow hover:text-dark-red transition shadow-xl font-bold transform hover:scale-105 active:scale-95">
                        Mulai Belanja
                    </a>
                </div>
            `;
            updateSummary(0);
            return;
        }

        let html = '';
        let total = 0;

        if (checkoutSection) checkoutSection.style.display = 'block';

        cart.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            html += `
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 flex flex-col md:flex-row items-center gap-8 group transition hover:shadow-2xl">
                    <img src="${item.image}" class="w-28 h-28 object-cover rounded-2xl shadow-md border-4 border-white">
                    <div class="flex-grow text-center md:text-left">
                        <h4 class="text-xl font-black text-gray-800 mb-1">${item.name}</h4>
                        <p class="text-dark-red font-black text-lg">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                    </div>
                    <div class="flex items-center space-x-6 bg-gray-50 px-4 py-2 rounded-2xl border border-gray-100">
                        <button onclick="updateQty(${index}, -1)" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-gray-600 hover:bg-dark-red hover:text-white transition font-black">-</button>
                        <span class="font-black text-xl w-6 text-center">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-gray-600 hover:bg-dark-red hover:text-white transition font-black">+</button>
                    </div>
                    <div class="flex flex-col items-end">
                        <p class="text-[10px] text-gray-400 font-black uppercase mb-1">Subtotal Item</p>
                        <p class="font-black text-gray-800 text-xl tracking-tighter">
                            Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}
                        </p>
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-gray-300 hover:text-red-500 transition-colors p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
        });

        container.innerHTML = html;
        updateSummary(total);
    }

    function updateQty(index, delta) {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart[index].qty += delta;
        if (cart[index].qty < 1) cart[index].qty = 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    function removeFromCart(index) {
        Swal.fire({
            title: 'Hapus Menu?',
            text: "Apakah kamu yakin ingin menghapus menu ini dari keranjang?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#9B1A1A',
            cancelButtonColor: '#aaaaaa',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            borderRadius: '2rem',
            customClass: {
                popup: 'rounded-[2.5rem] shadow-2xl border-none',
                title: 'text-2xl font-black text-gray-800',
                htmlContainer: 'text-sm font-medium text-gray-500',
                confirmButton: 'rounded-full px-8 py-3 font-black uppercase text-xs tracking-widest',
                cancelButton: 'rounded-full px-8 py-3 font-black uppercase text-xs tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
                
                const cartCountBadge = document.getElementById('cart-count');
                if (cartCountBadge) cartCountBadge.innerText = cart.length;
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: cart.length } }));

                Swal.fire({
                    title: 'Terhapus!',
                    text: 'Barang berhasil dikeluarkan dari keranjang.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    borderRadius: '2rem',
                    customClass: {
                        popup: 'rounded-[2.5rem] shadow-2xl'
                    }
                });
            }
        });
    }

    function updateSummary(total) {
        document.getElementById('subtotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
@endsection
