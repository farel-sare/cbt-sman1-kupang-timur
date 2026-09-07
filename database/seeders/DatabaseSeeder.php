<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Akun Admin Utama
        User::create([
            'name' => 'Administrator Utama',
            'username' => 'admin', // Username untuk login
            'password' => Hash::make('password123'), // Password untuk login
            'role' => 'admin',
        ]);
    }
}
