<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'name',
    ];

    // Relasi ke Jadwal Ujian
    public function jadwalUjians()
    {
        return $this->hasMany(JadwalUjian::class, 'mata_pelajaran_id');
    }

    // Relasi ke Bank Soal (Mengatasi error BadMethodCallException)
    public function soals()
    {
        return $this->hasMany(Soal::class, 'mata_pelajaran_id');
    }
}
