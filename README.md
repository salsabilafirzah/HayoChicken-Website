# Hayo Chicken - Sistem Pemesanan Makanan

**Hayo Chicken** adalah platform pemesanan makanan berbasis web (Sistem Informasi Restoran) yang dikembangkan untuk menyederhanakan proses transaksi bagi pelanggan dan mengoptimalkan manajemen operasional bagi administrator. Sistem ini dibangun dengan fokus pada antarmuka yang bersih (*clean UI*), interaktif, serta manajamen data yang responsif.

---

## Arsitektur & Teknologi

Proyek ini dibangun berdasarkan struktur spesifik dari repositori ini, menggunakan ekosistem *modern stack*:

| Komponen | Teknologi | Keterangan |
|---|---|---|
| **Lingkungan** | PHP >= 8.3 | Minimum versi bahasa pemrograman PHP yang dibutuhkan. |
| **Framework Utama** | [Laravel 13.x](https://laravel.com) | Digunakan untuk mengelola alur logika server (*backend*). |
| **Autentikasi** | Laravel Fortify | Modul keamanan untuk *login*, sesi pengguna, dan otorisasi. |
| **Frontend & UI** | Blade, Tailwind v4, Alpine.js | Untuk hasil antarmuka (*styling*) yang reaktif dan modern. |
| **Asset Bundler** | Vite 8 | Melakukan prakompilasi (*build*) aset CSS dan JS secara cepat. |
| **Database Engine** | MySQL | Sebagai pangkalan data untuk menyimpan berbagai detail transaksi. |

---

## Fitur-Fitur 

### Antarmuka Pelanggan (Customer)

| Fitur Pelanggan | Fungsionalitas |
|---|---|
| **Katalog Dinamis** | Memungkinkan pencarian menu dan pemilahan kategori dengan cepat tanpa *reload*. |
| **Keranjang Interaktif** | Simulasi keranjang belanja untuk mengalkulasi total pesanan sebelum melangkah ke pembayaran. |
| **Checkout Fleksibel** | Mendukung pembayaran secara elektronik via **QRIS** (Unggah Bukti) maupun tunai via **COD**. |
| **Dashboard Pemantauan** | Melacak dan melihat langsung riwayat setiap tahapan pesanan pengguna secara transparan. |

### Panel Administrator (Admin)

| Fitur Administrator | Fungsionalitas |
|---|---|
| **Dasbor Analitik** | Melihat kompilasi data statistik penjualan serta rincian makanan-minuman terlaris. |
| **Manajemen Menu** | Memanipulasi basis data menu (Tambah, Ubah, Hapus) termasuk mengatur harga, foto, dan ketersediaan stok. |
| **Manajemen Pesanan** | Menentukan fase pengiriman (Verifikasi Bukti QRIS -> Diproses -> Dikirim -> Pesanan Selesai). |

---

## Instalasi & Menjalankan Project (Localhost)

Ikuti panduan berikut untuk kloning dan menjalankan *project* ini di laptop/komputer Anda. Pastikan Anda telah menginstal **PHP (Minimal versi 8.3)**, **Composer**, dan **Node.js**.

Anda dapat menyalin (*copy*) blok kode di bawah ini ke terminal Anda:

**1. Clone Repository & Masuk ke Direktori**
```bash
git clone <URL_REPOSITORY_ANDA>
cd HayoChicken-Website
```

**2. Instalasi Dependensi (Vendor & Node Modules)**
```bash
composer install
npm install
```

**3. Setup Environment (.env)**
```bash
cp .env.example .env
php artisan key:generate
```

**Catatan Konfigurasi Database:** 
Buka file `.env` di teks editor Anda. Pastikan Anda sudah membuat database kosong *(misalnya di phpMyAdmin)* dan sesuaikan nama databasenya pada variabel `DB_DATABASE=`. Anda tidak perlu menyalin banyak kode, cukup sesuaikan nama database, *username*, dan *password* lokal Anda.

**4. Migrasi & Seeding Database**
Perintah ini akan membangun struktur tabel sekaligus mengisi data *dummy* dasar (seperti akun *admin* dan data menu):
```bash
php artisan migrate --seed
```

**5. Kompilasi Aset Frontend (Tailwind/Vite)**
```bash
npm run build
```

**6. Jalankan Server Development**
```bash
php artisan serve
```
Setelah server menyala, buka browser Anda dan akses tautan lokal: `http://127.0.0.1:8000`

---

## Tim Pengembang

Proyek website **Hayo Chicken** ini dikembangkan untuk penyelesaian Tugas Besar **Mata Kuliah Pemrograman Web 2**. 

**Anggota Kelompok:**

| No | Nama Lengkap | NIM |
|:---:|:---|:---|
| 1 | Salsabila Firzah Amanina | H1D024069 |
| 2 | Putri Isnaini Laksita Utami | H1D024078 |
| 3 | Hana Naila Rahmadina | H1D024093 |
| 4 | Zainab Feizia | H1D024097 |
