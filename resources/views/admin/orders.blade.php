@extends('layouts.admin')

@section('page_title', 'Antrean Pesanan')

@section('content')
<div class="max-w-6xl mx-auto space-y-8" x-data="{ showReceiptModal: false, currentReceipt: '' }">
    
    <!-- Meta Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-dark-red tracking-tighter leading-tight">Kelola Antrean</h2>
            <p class="text-[10px] font-bold text-slate-400 tracking-[0.2em] -mt-1">Pantau & Proses Pesanan Pelanggan</p>
        </div>
        <div class="flex items-center space-x-2 bg-white px-6 py-3 rounded-2xl shadow-sm border border-dark-red/5">
            <span class="w-2.5 h-2.5 bg-bright-yellow rounded-full animate-ping"></span>
            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">{{ $orders->total() }} Pesanan Masuk</span>
        </div>
    </div>

    <!-- Order Cards Grid -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($orders as $order)
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-dark-red/5 overflow-hidden hover:shadow-xl hover:shadow-bright-yellow/5 transition-all duration-500 group">
            <!-- Card Header -->
            <div class="px-8 py-5 bg-soft-cream/30 border-b border-dark-red/5 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-xl font-black text-dark-red">#{{ $order->id }}</span>
                    <span class="h-4 w-px bg-dark-red/10"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $order->payment_method === 'qris' ? 'bg-indigo-50 text-indigo-500 border border-indigo-100' : 'bg-emerald-50 text-emerald-500 border border-emerald-100' }}">
                        {{ strtoupper($order->payment_method) }}
                    </span>
                    @if($order->payment_method === 'qris' && $order->payment_receipt)
                    <button @click="currentReceipt = '{{ asset('storage/' . $order->payment_receipt) }}'; showReceiptModal = true" class="bg-white border border-slate-200 text-slate-600 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-dark-red hover:text-white transition shadow-sm">
                        Cek Bukti
                    </button>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Customer Info -->
                <div class="lg:col-span-4 space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Pelanggan</label>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 font-black">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <h4 class="text-base font-black text-slate-800">{{ $order->user->name }}</h4>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 text-dark-red/50">Alamat Pengiriman</label>
                        <div class="bg-soft-cream/30 p-4 rounded-2xl border border-dark-red/5">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-dark-red mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="ml-2 text-xs font-bold text-slate-600 leading-relaxed">{{ $order->delivery_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="lg:col-span-5 border-l border-slate-50 lg:pl-8">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">Rincian Belanjaan</label>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between group/item">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl overflow-hidden border border-slate-100 flex-shrink-0">
                                    <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : (Str::startsWith($item->product->image, 'images/') ? asset($item->product->image) : asset('storage/' . $item->product->image)) }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-xs font-black text-slate-700">{{ $item->product->name }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-[10px] font-bold text-slate-400">x{{ $item->qty }}</span>
                                <span class="text-xs font-black text-slate-800">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="lg:col-span-3 flex flex-col justify-between border-l border-slate-50 lg:pl-8">
                    <div class="text-right">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Total Tagihan</label>
                        <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>
                    </div>

                    <div class="mt-4">
                        @php
                            $status_classes = [
                                'pending' => 'bg-[#FFF9E6] text-[#B88600] border-[#FFECB3]',
                                'verifying' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'processing' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'shipping' => 'bg-purple-50 text-purple-600 border-purple-100',
                                'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                            ];
                            $status_labels = [
                                'pending' => 'Menunggu Pembayaran',
                                'verifying' => 'Proses Verifikasi',
                                'processing' => 'Sedang Dimasak',
                                'shipping' => 'Dalam Pengiriman',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <div class="flex justify-end mb-4">
                            <span class="px-4 py-2 rounded-2xl text-[10px] font-bold shadow-sm border {{ $status_classes[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $status_labels[$order->status] ?? $order->status }}
                            </span>
                        </div>

                        <div class="flex justify-end">
                            <div class="w-full space-y-2">
                                @if(in_array($order->status, ['pending', 'verifying']))
                                    <form id="status-form-{{ $order->id }}" action="{{ route('admin.orders.status', $order) }}" method="POST" class="grid grid-cols-2 gap-2 w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="confirmStatus('Terima Pesanan?', 'Pesanan akan diproses dan kamu harus segera menyiapkan makanannya.', 'Ya, Terima', 'processing', 'status-form-{{ $order->id }}')" class="bg-[#10B981] text-white font-bold py-3 rounded-2xl text-[11px] hover:bg-[#059669] transition shadow-lg shadow-emerald-500/20 active:scale-95">Terima</button>
                                        <button type="button" onclick="confirmStatus('Tolak Pesanan?', 'Yakin ingin menolak pesanan ini?', 'Ya, Tolak', 'cancelled', 'status-form-{{ $order->id }}')" class="bg-[#EF4444] text-white font-bold py-3 rounded-2xl text-[11px] hover:bg-[#DC2626] transition shadow-lg shadow-red-500/20 active:scale-95">Tolak</button>
                                    </form>
                                @elseif($order->status === 'processing')
                                    <form id="status-form-{{ $order->id }}" action="{{ route('admin.orders.status', $order) }}" method="POST" class="grid grid-cols-2 gap-2 w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="confirmStatus('Kirim Pesanan?', 'Pesanan ditandai Dalam Pengiriman. Pastikan kamu sudah berangkat!', 'Ya, Kirim', 'shipping', 'status-form-{{ $order->id }}')" class="bg-indigo-500 text-white font-bold py-3 rounded-2xl text-[11px] hover:bg-indigo-600 transition shadow-lg shadow-indigo-500/20 active:scale-95">Kirim</button>
                                        <button type="button" onclick="confirmStatus('Batalkan Pesanan?', 'Yakin ingin membatalkan pesanan ini?', 'Ya, Batal', 'cancelled', 'status-form-{{ $order->id }}')" class="bg-slate-200 text-slate-500 font-bold py-3 rounded-2xl text-[11px] hover:bg-slate-300 transition active:scale-95">Batal</button>
                                    </form>
                                @elseif($order->status === 'shipping')
                                    <form id="status-form-{{ $order->id }}" action="{{ route('admin.orders.status', $order) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="confirmStatus('Tandai Selesai?', 'Konfirmasi pesanan sudah diterima pembeli dengan baik', 'Selesai', 'completed', 'status-form-{{ $order->id }}')" class="w-full bg-[#A1000C] text-white font-bold py-3 rounded-2xl text-[11px] hover:bg-[#8A000A] transition shadow-lg shadow-dark-red/20 active:scale-95">Selesaikan Pesanan</button>
                                    </form>
                                @else
                                    <div class="w-full text-center py-3 border-2 border-dashed border-dark-red/10 rounded-2xl bg-soft-cream/10">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Riwayat Selesai</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-[3rem] p-32 text-center border-2 border-dashed border-slate-100 shadow-inner">
            <div class="flex flex-col items-center opacity-30">
                <svg class="w-24 h-24 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-2xl font-black uppercase tracking-tighter">Santai Dulu, Belum Ada Orderan</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="py-12 flex justify-center">
        {{ $orders->links() }}
    </div>
    @endif

    <!-- MODAL: VIEW RECEIPT -->
    <div x-show="showReceiptModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-12">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showReceiptModal = false"></div>
        <div class="relative bg-white w-full max-w-xl rounded-[2.5rem] md:rounded-[4rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300 max-h-[90vh] flex flex-col">
            <!-- Header Modal (Sticky) -->
            <div class="p-6 md:p-8 border-b border-dark-red/5 flex justify-between items-center bg-soft-cream/50 flex-shrink-0">
                <h3 class="text-sm font-black text-dark-red uppercase tracking-widest">Bukti Bayar QRIS</h3>
                <button @click="showReceiptModal = false" class="text-slate-400 hover:text-dark-red transition p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body Modal (Scrollable) -->
            <div class="p-6 md:p-12 overflow-y-auto bg-soft-cream/10 flex-grow custom-scrollbar">
                <div class="flex justify-center">
                    <img :src="currentReceipt" class="max-w-full rounded-[2rem] shadow-2xl border-4 md:border-8 border-white transform hover:scale-[1.02] transition duration-500">
                </div>
            </div>
            
            <!-- Footer Modal (Sticky) -->
            <div class="p-6 md:p-8 bg-white flex justify-center border-t border-dark-red/5 flex-shrink-0">
                <button @click="showReceiptModal = false" class="w-full md:w-auto bg-dark-red text-white font-black px-16 py-4 rounded-full shadow-xl shadow-dark-red/20 uppercase text-xs tracking-widest hover:bg-bright-yellow hover:text-dark-red transition active:scale-95">Tutup Preview</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmStatus(title, text, confirmButtonText, statusValue, formId) {
        Swal.fire({
            title: title,
            text: text,
            icon: statusValue === 'cancelled' ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: statusValue === 'cancelled' ? '#EF4444' : '#A1000C',
            cancelButtonColor: '#94A3B8',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Batal',
            reverseButtons: true,
            borderRadius: '2rem',
            customClass: {
                title: 'text-xl font-black text-slate-800 tracking-tight',
                popup: 'rounded-[2.5rem] p-8',
                confirmButton: 'rounded-2xl px-8 py-3 font-bold uppercase text-xs tracking-widest',
                cancelButton: 'rounded-2xl px-8 py-3 font-bold uppercase text-xs tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(formId);
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'status';
                input.value = statusValue;
                form.appendChild(input);
                form.submit();
            }
        });
    }
</script>
@endsection

