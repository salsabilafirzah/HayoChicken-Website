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
            [
                'name' => 'Ayam Crispy Original',
                'category' => 'Main Course',
                'description' => 'Ayam goreng renyah dengan bumbu rahasia Hayo Chicken.',
                'price' => 15000,
                'image' => 'products/ayam-crispy.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh Manis',
                'category' => 'Drink',
                'description' => 'Es teh manis segar dari daun teh pilihan.',
                'price' => 5000,
                'image' => 'products/es-teh.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Rice Bowl Chicken Teriyaki',
                'category' => 'Rice Bowl',
                'description' => 'Nasi hangat dengan potongan ayam saus teriyaki dan telur.',
                'price' => 20000,
                'image' => 'products/rice-bowl.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Kentang Goreng',
                'category' => 'Snack',
                'description' => 'Kentang goreng gurih dan renyah dengan taburan garam.',
                'price' => 12000,
                'image' => 'products/french-fries.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Burger Chicken Deluxe',
                'category' => 'Burger',
                'description' => 'Burger ayam dengan sayuran segar dan saus spesial.',
                'price' => 18000,
                'image' => 'products/burger.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Nugget Ayam (6 pcs)',
                'category' => 'Snack',
                'description' => 'Nugget ayam empuk dan gurih isi 6 potong.',
                'price' => 15000,
                'image' => 'products/nugget.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
