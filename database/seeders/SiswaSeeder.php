<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh menambah 3 siswa sekaligus
        $siswas = [
            ['name' => 'farel', 'username' => '2026001', 'role' => 'siswa'],
            ['name' => 'Budi Santoso', 'username' => '2026002', 'role' => 'siswa'],
            ['name' => 'Citra Lestari', 'username' => '2026003', 'role' => 'siswa'],
        ];

        foreach ($siswas as $s) {
            User::create([
                'name' => $s['name'],
                'username' => $s['username'],
                'password' => Hash::make('password123'), // Default password
                'role' => $s['role'],
            ]);
        }
    }
}
