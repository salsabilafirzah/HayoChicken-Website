<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Hayo Chicken Admin',
            'email' => 'owner@hayochicken.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '08123456789',
            'address' => 'Jl. Hayo Chicken No. 1',
        ]);

        // Buyer
        User::create([
            'name' => 'John Doe',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '08987654321',
            'address' => 'Jl. Mawar Merah No. 10',
        ]);
    }
}
