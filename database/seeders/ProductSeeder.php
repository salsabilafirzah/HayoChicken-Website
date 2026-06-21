<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // KATEGORI: PAKET
            [
                'name' => 'Paket Ayam Geprek',
                'category' => 'Paket',
                'description' => 'Paket komplit: Ayam geprek pedas (Pilihan: Sayap/Paha/Dada) + Nasi Putih hangat + Es Teh Manis segar.',
                'price' => 16000,
                'image' => 'images/paket_geprek.png',
                'is_available' => true,
            ],
            [
                'name' => 'Paket Nasi Goreng',
                'category' => 'Paket',
                'description' => 'Nasi goreng spesial bumbu Hayo + Telur ceplok/dadar + Es Teh Manis.',
                'price' => 17000,
                'image' => 'images/paket_nasgor.png',
                'is_available' => true,
            ],
            [
                'name' => 'Paket Chicken Katsu',
                'category' => 'Paket',
                'description' => 'Ayam katsu renyah dengan saus spesial + Nasi Putih + Es Teh Manis.',
                'price' => 19000,
                'image' => 'images/paket_katsu.png',
                'is_available' => true,
            ],
            [
                'name' => 'Paket Chicken Teriyaki',
                'category' => 'Paket',
                'description' => 'Potongan ayam saus teriyaki gurih + Nasi Putih + Es Teh Manis.',
                'price' => 16000,
                'image' => 'images/paket_teriyaki.png',
                'is_available' => true,
            ],
            [
                'name' => 'Paket Ayam Lalapan',
                'category' => 'Paket',
                'description' => 'Ayam goreng (Pilihan: Sayap/Paha/Dada) + Sambal lalapan segar + Nasi Putih + Es Teh Manis.',
                'price' => 16000,
                'image' => 'images/paket_lalapan.png',
                'is_available' => true,
            ],

            // KATEGORI: CEMILAN
            [
                'name' => 'Kentang Goreng',
                'category' => 'Cemilan',
                'description' => 'Kentang goreng gurih nan renyah, pas untuk teman ngobrol.',
                'price' => 11000,
                'image' => 'images/kentang.png',
                'is_available' => true,
            ],
            [
                'name' => 'Nugget',
                'category' => 'Cemilan',
                'description' => 'Nugget ayam goreng hangat isi 5-6 pcs per porsi.',
                'price' => 11000,
                'image' => 'images/nugget.png',
                'is_available' => true,
            ],
            [
                'name' => 'Sosis',
                'category' => 'Cemilan',
                'description' => 'Sosis goreng bumbu barbeque/original yang lezat.',
                'price' => 11000,
                'image' => 'images/sosis.png',
                'is_available' => true,
            ],
            [
                'name' => 'Cireng',
                'category' => 'Cemilan',
                'description' => 'Cireng crispy dengan bumbu rujak pedas manis.',
                'price' => 11000,
                'image' => 'images/cireng.png',
                'is_available' => true,
            ],
            [
                'name' => 'Otak-otak',
                'category' => 'Cemilan',
                'description' => 'Otak-otak ikan goreng yang kenyal dan gurih.',
                'price' => 11000,
                'image' => 'images/otak_otak.png',
                'is_available' => true,
            ],

            // KATEGORI: MINUMAN
            [
                'name' => 'Es Teh Manis',
                'category' => 'Minuman',
                'description' => 'Es teh manis segar dari daun teh pilihan.',
                'price' => 3000,
                'image' => 'images/esteh.png',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh Lemon',
                'category' => 'Minuman',
                'description' => 'Perpaduan es teh dengan sensasi asam lemon yang segar.',
                'price' => 5000,
                'image' => 'images/eslemon.png',
                'is_available' => true,
            ],
            [
                'name' => 'Jus Mangga',
                'category' => 'Minuman',
                'description' => 'Jus mangga asli yang manis dan kental.',
                'price' => 9000,
                'image' => 'images/jus_mangga.png',
                'is_available' => true,
            ],
            [
                'name' => 'Es Jeruk',
                'category' => 'Minuman',
                'description' => 'Minuman jeruk peras asli, kaya akan vitamin C.',
                'price' => 6000,
                'image' => 'images/esjeruk.png',
                'is_available' => true,
            ],
            [
                'name' => 'Teh Hangat',
                'category' => 'Minuman',
                'description' => 'Teh hangat untuk menenangkan suasana.',
                'price' => 2000,
                'image' => 'images/teh_hangat.png',
                'is_available' => true,
            ],

            // KATEGORI: AYAM
            [
                'name' => 'Ayam Geprek (Alacarte)',
                'category' => 'Ayam',
                'description' => 'Hanya ayam geprek pedas nampol (Pilihan: Sayap/Paha/Dada).',
                'price' => 8000,
                'image' => 'images/ayam_geprek.png',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Krispi (Alacarte)',
                'category' => 'Ayam',
                'description' => 'Ayam goreng original Hayo yang krispi (Pilihan: Sayap/Paha/Dada).',
                'price' => 7000,
                'image' => 'images/ayam_krispi.png',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Katsu',
                'category' => 'Ayam',
                'description' => 'Potongan ayam katsu lezat tanpa nasi.',
                'price' => 9000,
                'image' => 'images/ayam_katsu.png',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Lalapan',
                'category' => 'Ayam',
                'description' => 'Ayam goreng porsi alacarte lengkap dengan sambal lalapan.',
                'price' => 7000,
                'image' => 'images/ayam_lalapan.png',
                'is_available' => true,
            ],

            // KATEGORI: MIE
            [
                'name' => 'Mie Kuah',
                'category' => 'Mie',
                'description' => 'Mie kuah hangat dengan topping telur dan sayuran.',
                'price' => 13000,
                'image' => 'images/mie_kuah.png',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Goreng',
                'category' => 'Mie',
                'description' => 'Mie goreng spesial bumbu Hayo dengan topping lengkap.',
                'price' => 14000,
                'image' => 'images/mie_goreng.png',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Jebew',
                'category' => 'Mie',
                'description' => 'Mie super pedas khas Jebew, khusus buat kamu pecinta pedas!',
                'price' => 16000,
                'image' => 'images/mie_jebew.png',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
