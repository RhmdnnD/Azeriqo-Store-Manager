<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Owner Azeriqo',
            'email' => 'admin@azeriqo.com',
            'password' => Hash::make('password123'), // Ganti ini nanti jika mau
            'role' => 'admin',
        ]);
    }
}