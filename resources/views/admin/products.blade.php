@extends('layouts.admin')

@section('page_title', 'Kelola Menu')

@section('content')
<div class="space-y-6" x-data="{ showAddModal: false, showEditModal: false, currentProduct: {} }">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-dark-red/5">
        <div>
            <h3 class="text-xl font-black text-dark-red tracking-tight leading-none">Daftar Menu</h3>
            <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-0.5">Total {{ $products->total() }} Produk Aktif</p>
        </div>
        <button @click="showAddModal = true" class="bg-dark-red text-white font-black px-8 py-3 rounded-2xl shadow-lg shadow-dark-red/20 hover:bg-bright-yellow hover:text-dark-red transition transform hover:-translate-y-1 active:scale-95 text-[10px] uppercase tracking-widest">
            Tambah Menu Baru
        </button>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-[3rem] overflow-hidden shadow-sm border border-dark-red/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-soft-cream/30 text-[10px] text-slate-400 uppercase tracking-widest border-b border-dark-red/5">
                        <th class="px-8 py-6 font-black">Produk</th>
                        <th class="px-8 py-6 font-black">Kategori</th>
                        <th class="px-8 py-6 font-black">Deskripsi</th>
                        <th class="px-8 py-6 font-black">Harga</th>
                        <th class="px-8 py-6 font-black text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-red/5">
                    @forelse($products as $product)
                    <tr class="group hover:bg-bright-yellow/5 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : (Str::startsWith($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image)) }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-sm font-black text-slate-800">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-3 py-1 bg-bright-yellow/10 rounded-full text-[9px] font-black uppercase tracking-wider text-dark-red">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            <p class="text-xs text-slate-500 font-medium line-clamp-2 max-w-xs">{{ $product->description }}</p>
                        </td>
                        <td class="px-8 py-4 font-black text-sm text-slate-800">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-end space-x-2">
                                <button @click="currentProduct = {{ $product }}; showEditModal = true" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-sm">Belum ada produk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- MODAL: ADD PRODUCT -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showAddModal = false"></div>
        <div class="relative bg-white w-full max-w-xl max-h-[90vh] overflow-y-auto overscroll-contain rounded-[2.5rem] shadow-2xl p-8 animate-in zoom-in duration-300 custom-scrollbar">
            <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mb-8">Tambah Menu Baru</h3>
            
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Produk</label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red" placeholder="Contoh: Ayam Geprek">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                        <select name="category" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red">
                            <option value="Paket">Paket</option>
                            <option value="Cemilan">Cemilan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Ayam">Ayam</option>
                            <option value="Mie">Mie</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Harga (Rp)</label>
                    <input type="number" name="price" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red" placeholder="25000">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi Produk</label>
                    <textarea name="description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red" placeholder="Jelaskan kelezatan menu ini..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Menu</label>
                    <input type="file" name="image" accept="image/png, image/jpeg" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red">
                </div>

                <div class="pt-4 flex space-x-3">
                    <button type="button" @click="showAddModal = false" class="flex-1 bg-slate-100 text-slate-600 font-bold py-4 rounded-2xl hover:bg-slate-200 transition uppercase text-xs tracking-widest">Batal</button>
                    <button type="submit" class="flex-2 bg-dark-red text-white font-black py-4 px-12 rounded-2xl shadow-xl hover:bg-bright-yellow hover:text-dark-red transition uppercase text-xs tracking-widest">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT PRODUCT -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showEditModal = false"></div>
        <div class="relative bg-white w-full max-w-xl max-h-[90vh] overflow-y-auto overscroll-contain rounded-[2.5rem] shadow-2xl p-8 animate-in zoom-in duration-300 custom-scrollbar">
            <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mb-8">Edit Menu</h3>
            
            <form :action="'{{ url('admin/products') }}/' + currentProduct.id" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Produk</label>
                        <input type="text" name="name" x-model="currentProduct.name" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                        <select name="category" x-model="currentProduct.category" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red">
                            <option value="Paket">Paket</option>
                            <option value="Cemilan">Cemilan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Ayam">Ayam</option>
                            <option value="Mie">Mie</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Harga (Rp)</label>
                    <input type="number" name="price" x-model="currentProduct.price" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Deskripsi Produk</label>
                    <textarea name="description" x-model="currentProduct.description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" accept="image/png, image/jpeg" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-dark-red">
                </div>

                <div class="pt-4 flex space-x-3">
                    <button type="button" @click="showEditModal = false" class="flex-1 bg-slate-100 text-slate-600 font-bold py-4 rounded-2xl hover:bg-slate-200 transition uppercase text-xs tracking-widest">Batal</button>
                    <button type="submit" class="flex-2 bg-dark-red text-white font-black py-4 px-12 rounded-2xl shadow-xl hover:bg-bright-yellow hover:text-dark-red transition uppercase text-xs tracking-widest">Update Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Menu?',
            text: `Kamu yakin ingin menghapus "${name}" dari daftar menu?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#9B1A1A',
            cancelButtonColor: '#94A3B8',
            confirmButtonText: 'Ya, Hapus!',
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
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
