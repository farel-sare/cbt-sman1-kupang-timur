<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            ['name' => 'Pendidikan Agama dan Budi Pekerti'],
            ['name' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['name' => 'Bahasa Indonesia'],
            ['name' => 'Matematika Wajib'],
            ['name' => 'Sejarah Indonesia'],
            ['name' => 'Bahasa Inggris'],
            ['name' => 'Seni Budaya'],
            ['name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan'],
            ['name' => 'Prakarya dan Kewirausahaan'],
            ['name' => 'Matematika Peminatan'],
            ['name' => 'Biologi'],
            ['name' => 'Fisika'],
            ['name' => 'Kimia'],
            ['name' => 'Geografi'],
            ['name' => 'Sejarah Peminatan'],
            ['name' => 'Sosiologi'],
            ['name' => 'Ekonomi'],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::firstOrCreate($m);
        }
    }
}
