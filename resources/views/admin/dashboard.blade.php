@extends('layouts.admin')

@section('page_title', 'Dashboard Analitik')

@section('content')
<div class="space-y-8">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-dark-red/5 flex items-center space-x-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-dark-red flex-shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Omzet</p>
                <h3 class="text-xl font-black text-slate-800">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-dark-red/5 flex items-center space-x-4">
            <div class="w-14 h-14 bg-bright-yellow/10 rounded-2xl flex items-center justify-center text-bright-yellow flex-shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pesanan</p>
                <h3 class="text-xl font-black text-slate-800">{{ $stats['total_orders'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-dark-red/5 flex items-center space-x-4">
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 flex-shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu Masak</p>
                <h3 class="text-xl font-black text-slate-800">{{ $stats['pending_orders'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-dark-red/5 flex items-center space-x-4">
            <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menu Aktif</p>
                <h3 class="text-xl font-black text-slate-800">{{ $stats['total_products'] }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
        <!-- Payment Summary Report -->
        <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 shadow-sm border border-dark-red/5 flex flex-col h-[650px] overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight leading-none">Ringkasan Pembayaran</h3>
                    <p class="text-sm text-slate-400 font-medium italic mt-1">Laporan rincian transaksi bulanan</p>
                </div>
                <button onclick="window.print()" class="bg-dark-red text-white p-3 rounded-2xl transition shadow-lg shadow-dark-red/20 group hover:bg-bright-yellow hover:text-dark-red">
                    <div class="flex items-center space-x-2 px-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span class="text-xs font-black uppercase tracking-widest">Cetak PDF</span>
                    </div>
                </button>
            </div>
            
            <div id="printableReport" class="flex-grow overflow-y-auto pr-2 custom-scrollbar">
                <!-- PRINT ONLY HEADER -->
                <div class="hidden print:block mb-8 border-b-4 border-dark-red pb-4">
                    <div class="flex justify-between items-end">
                        <div>
                            <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">Laporan Penjualan</h1>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Hayo Chicken Premium Dapur</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dicetak Pada</p>
                            <p class="text-xs font-bold text-slate-800">{{ now()->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    @foreach($report_orders as $order)
                    <div class="border border-slate-100 rounded-3xl p-6 bg-slate-50/30 print:border-slate-200 print:rounded-xl print:bg-white print:p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-xs font-black text-slate-800">Order #HC-{{ $order->created_at->format('Ymd') }}-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">Pelanggan: {{ $order->user->name }}</p>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 mb-4 print:border-slate-200 print:rounded-lg">
                            <table class="w-full text-[10px]">
                                <thead class="bg-slate-50 text-slate-400 font-black uppercase print:bg-slate-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Item</th>
                                        <th class="px-2 py-2 text-center">Qty</th>
                                        <th class="px-4 py-2 text-right">Harga</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 print:divide-slate-100">
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-2 font-bold text-slate-700">{{ $item->product->name }}</td>
                                        <td class="px-2 py-2 text-center font-bold">{{ $item->qty }}</td>
                                        <td class="px-4 py-2 text-right font-bold text-dark-red">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] {{ $order->payment_method === 'qris' ? 'text-indigo-500' : 'text-emerald-500' }} print:text-slate-600">
                                    Tipe Kas: {{ strtoupper($order->payment_method) }}
                                </span>
                            </div>
                            <p class="text-xs font-black text-slate-800">Total: <span class="text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Report Footer: TOTAL KESELURUHAN (Inside printable area) -->
                <div class="mt-6 pt-6 border-t-2 border-dashed border-slate-100 print:border-slate-300">
                    <div class="bg-dark-red text-white rounded-2xl p-5 flex justify-between items-center shadow-lg shadow-dark-red/20 print:bg-dark-red print:text-white print:rounded-xl print:p-4" style="-webkit-print-color-adjust: exact;">
                        <span class="text-xs font-black uppercase tracking-[0.3em]">Total Keseluruhan</span>
                        <span class="text-xl font-black">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @media print {
                body * { visibility: hidden; }
                #printableReport, #printableReport * { visibility: visible; }
                #printableReport { 
                    position: absolute; 
                    left: 0; 
                    top: 0; 
                    width: 100%;
                    overflow: visible !important;
                    padding: 20px !important;
                }
                .lg\:col-span-2 { border: none !important; box-shadow: none !important; }
                /* Force background colors in print */
                * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            }
        </style>

        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-dark-red/5 h-[650px] flex flex-col">
            <h3 class="text-xl font-black text-slate-800 tracking-tight mb-8">Metode Pembayaran</h3>
            
            <div class="space-y-8">
                <!-- QRIS -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">QRIS (Otomatis)</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tanpa Kembalian</p>
                            </div>
                        </div>
                        <span class="text-lg font-black text-slate-800">Rp {{ number_format($stats['revenue_qris'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        @php $qris_percent = $stats['total_revenue'] > 0 ? ($stats['revenue_qris'] / $stats['total_revenue']) * 100 : 0; @endphp
                        <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000" style="width: {{ $qris_percent }}%"></div>
                    </div>
                </div>

                <!-- COD -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Bayar Ditempat (COD)</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Uang Tunai</p>
                            </div>
                        </div>
                        <span class="text-lg font-black text-slate-800">Rp {{ number_format($stats['revenue_cod'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        @php $cod_percent = $stats['total_revenue'] > 0 ? ($stats['revenue_cod'] / $stats['total_revenue']) * 100 : 0; @endphp
                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $cod_percent }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-12 bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <div class="space-y-4">
                    <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Rasio Pembayaran</span>
                    <div class="flex items-center justify-between bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="text-center flex-1 border-r border-slate-50">
                            <p class="text-lg font-black text-indigo-600">{{ round($qris_percent) }}%</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">QRIS</p>
                        </div>
                        <div class="text-center flex-1">
                            <p class="text-lg font-black text-emerald-600">{{ round($cod_percent) }}%</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Tunai (COD)</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100/50">
                    <p class="text-[10px] text-slate-400 leading-relaxed italic">
                        <span class="font-bold text-indigo-400">Saran:</span>
                        @if($qris_percent >= $cod_percent)
                            Pertahankan promosi QRIS untuk mengurangi risiko kembalian uang tunai dan mempermudah audit kas harian.
                        @else
                            Pembayaran tunai masih mendominasi. Pertimbangkan promo khusus QRIS untuk mempercepat transaksi dan mengurangi risiko uang palsu/selisih kas.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Products -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <h3 class="text-xl font-black text-slate-800 tracking-tight mb-8">Menu Terlaris</h3>
            <div class="space-y-6">
                @foreach($top_products as $product)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : (Str::startsWith($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image)) }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800">{{ $product->name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $product->category }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-dark-red">{{ number_format($product->total_sold ?? 0, 0) }} Terjual</p>
                        <div class="w-24 bg-slate-100 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-dark-red h-full rounded-full" style="width: {{ min(100, ($product->total_sold ?? 0) * 5) }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-slate-800 tracking-tight">Transaksi Terakhir</h3>
                <a href="{{ route('admin.orders') }}" class="text-[10px] font-black text-dark-red uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] text-slate-400 uppercase tracking-widest border-b border-slate-50">
                            <th class="pb-4 font-black">ID Pesanan</th>
                            <th class="pb-4 font-black">Pelanggan</th>
                            <th class="pb-4 font-black">Total</th>
                            <th class="pb-4 font-black">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recent_orders as $order)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="py-4 font-bold text-xs">#{{ $order->id }}</td>
                            <td class="py-4">
                                <p class="text-xs font-black text-slate-800">{{ $order->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $order->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="py-4 font-black text-xs text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="py-4">
                                @php
                                    $status_classes = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'shipping' => 'bg-purple-100 text-purple-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider {{ $status_classes[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
