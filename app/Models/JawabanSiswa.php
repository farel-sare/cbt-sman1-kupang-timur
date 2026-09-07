<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;

    protected $table = 'jawaban_siswas';

    protected $fillable = [
        'user_id',
        'jadwal_ujian_id',
        'soal_id',
        'jawaban',
        'is_correct',
    ];
}
