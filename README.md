# Hayo Chicken - Sistem Pemesanan Makanan

Hayo Chicken adalah platform manajemen dan pemesanan makanan berbasis web yang dirancang untuk memberikan pengalaman transaksi yang intuitif bagi pelanggan serta manajemen operasional yang efisien bagi administrator.

## Arsitektur Teknologi

Sistem ini dibangun dengan menggunakan stack teknologi modern untuk memastikan performa yang optimal dan kemudahan pemeliharaan:

*   **Framework Utama:** Laravel 11.x
*   **Frontend Engine:** Blade Templating & Alpine.js (Reactive Client-Side Logic)
*   **Styling:** Tailwind CSS
*   **Database:** MySQL
*   **Authentication:** Laravel Fortify (Session-based dengan arsitektur modal)
*   **State Management:** LocalStorage (Untuk sistem Keranjang dan Favorit)

## Fitur Utama

### 1. Antarmuka Pelanggan (Customer Interface)
*   **Katalog Menu Dinamis:** Pencarian menu secara real-time dan filtrasi berdasarkan kategori tanpa reload halaman.
*   **Client-Side Shopping Cart:** Sistem keranjang belanja berbasis LocalStorage yang cepat dan responsif.
*   **Favorite Systems:** Memungkinkan pengguna untuk menandai menu favorit yang tersimpan secara lokal.
*   **Authentication Modal:** Sistem login dan registrasi yang terintegrasi dalam modal untuk menjaga alur navigasi pengguna.
*   **Order Tracking:** Dashboard pelanggan untuk memantau status pesanan dan riwayat transaksi.
*   **Payment Integration:** Dukungan pembayaran melalui QRIS (dengan unggah bukti bayar) dan Cash on Delivery (COD).

### 2. Panel Administrasi (Admin Dashboard)
*   **Analisis Penjualan:** Statistik pendapatan riwayat penjualan dan grafik perbandingan metode pembayaran.
*   **Produk Terlaris:** Laporan otomatis produk yang paling banyak terjual berdasarkan kuantitas pesanan selesai.
*   **Manajemen Produk:** Sistem CRUD (Create, Read, Update, Delete) produk dengan fiturnya unggah gambar dan manajemen ketersediaan stok.
*   **Manajemen Pesanan:** Pembaruan status pesanan (Verifikasi, Proses, Kirim, Selesai) secara real-time serta verifikasi bukti pembayaran QRIS.

## Keunggulan Sistem

*   **DRY Principle:** Kode program yang terpusat dan terstruktur untuk meminimalisir duplikasi.
*   **Responsive Design:** Tampilan yang optimal baik di perangkat desktop maupun perangkat mobile.
*   **Optimized Reporting:** Logika backend yang efisien untuk menghasilkan laporan statistik penjualan yang akurat.

## Instalasi

1. Clone repositori ini ke direktori lokal Anda.
2. Jalankan perintah `composer install` untuk menginstal dependensi backend.
3. Jalankan perintah `npm install` dan `npm run dev` untuk dependensi frontend.
4. Salin file `.env.example` menjadi `.env` dan konfigurasikan koneksi database Anda.
5. Jalankan perintah `php artisan key:generate`.
6. Jalankan migrasi database dengan perintah `php artisan migrate --seed`.
7. Jalankan server lokal dengan perintah `php artisan serve`.

## Hak Cipta
Dikembangkan untuk keperluan sistem manajemen pemesanan makanan Hayo Chicken.
