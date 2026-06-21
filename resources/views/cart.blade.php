@extends('layouts.hayo')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-extrabold text-dark-red uppercase tracking-wide border-l-8 border-bright-yellow pl-4">Keranjang Belanja</h2>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <div id="cart-items" class="space-y-6">
                <!-- Items will be injected by JS -->
                <div class="text-center py-20 bg-white rounded-3xl shadow-lg border border-gray-100">
                    <p class="text-gray-400 italic">Memuat keranjang...</p>
                </div>
            </div>
        </div>

        <!-- Order Summary & Checkout Form -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sticky top-24">
                <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-gray-500 border-b pb-4">
                        <span>Ongkos Kirim</span>
                        <span class="text-green-500 font-bold">GRATIS</span>
                    </div>
                    <div class="flex justify-between text-2xl font-black text-dark-red">
                        <span>Total</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>

                @auth
                <form id="checkout-form" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat Pengiriman</label>
                        <textarea name="delivery_address" class="w-full rounded-2xl border-gray-200 focus:ring-dark-red focus:border-dark-red p-4" rows="3" placeholder="Masukkan alamat lengkap pengiriman..." required>{{ auth()->user()->address ?? '' }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full rounded-2xl border-gray-200 focus:ring-dark-red focus:border-dark-red p-4 font-bold">
                            <option value="bank_transfer">Transfer Bank (BCA/Mandiri)</option>
                            <option value="e-wallet">E-Wallet (OVO/Dana/GoPay)</option>
                            <option value="cash">Bayar di Tempat (COD)</option>
                        </select>
                    </div>

                    <button type="submit" id="btn-checkout" class="w-full btn-primary text-xl py-4">Buat Pesanan Sekarang</button>
                </form>
                @else
                <div class="text-center py-6 border-t">
                    <p class="text-gray-500 mb-4">Silakan login untuk melanjutkan pemesanan.</p>
                    <a href="/login" class="btn-primary inline-block">Login Sekarang</a>
                </div>
                @endauth
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

                const btn = document.getElementById('btn-checkout');
                btn.disabled = true;
                btn.innerText = 'Memproses...';

                const formData = new FormData(form);
                const data = {
                    delivery_address: formData.get('delivery_address'),
                    payment_method: formData.get('payment_method'),
                    items: cart
                };

                try {
                    const response = await fetch('{{ route("orders.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();
                    if (result.success) {
                        localStorage.removeItem('cart');
                        window.location.href = result.redirect;
                    } else {
                        alert('Gagal membuat pesanan.');
                        btn.disabled = false;
                        btn.innerText = 'Buat Pesanan Sekarang';
                    }
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan.');
                    btn.disabled = false;
                    btn.innerText = 'Buat Pesanan Sekarang';
                }
            });
        }
    });

    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const container = document.getElementById('cart-items');
        
        if (cart.length === 0) {
            container.innerHTML = `
                <div class="text-center py-20 bg-white rounded-3xl shadow-lg border border-gray-100">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Keranjang Kosong</h3>
                    <p class="text-gray-400 mt-2 mb-6">Anda belum menambahkan menu apapun.</p>
                    <a href="/" class="text-dark-red font-bold hover:underline">Lihat Menu</a>
                </div>
            `;
            updateSummary(0);
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            html += `
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 flex flex-col md:flex-row items-center gap-6">
                    <img src="${item.image}" class="w-24 h-24 object-cover rounded-2xl">
                    <div class="flex-grow text-center md:text-left">
                        <h4 class="text-lg font-bold text-gray-800">${item.name}</h4>
                        <p class="text-dark-red font-black">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                    </div>
                    <div class="flex items-center space-x-4 bg-gray-50 p-2 rounded-2xl">
                        <button onclick="updateQty(${index}, -1)" class="w-8 h-8 flex items-center justify-center bg-white rounded-xl shadow-sm text-gray-600 hover:bg-dark-red hover:text-white transition">-</button>
                        <span class="font-bold w-4 text-center">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" class="w-8 h-8 flex items-center justify-center bg-white rounded-xl shadow-sm text-gray-600 hover:bg-dark-red hover:text-white transition">+</button>
                    </div>
                    <div class="font-black text-gray-800 w-32 text-right">
                        Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-gray-300 hover:text-red-500 transition">
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
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        
        // Update nav counter
        const cartCount = document.getElementById('cart-count');
        if (cartCount) cartCount.innerText = cart.length;
    }

    function updateSummary(total) {
        document.getElementById('subtotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
@endsection
