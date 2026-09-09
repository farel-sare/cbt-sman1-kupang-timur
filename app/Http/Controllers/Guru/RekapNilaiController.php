<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;

class RekapNilaiController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $jadwals = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)
            ->latest()
            ->paginate(10);

        return view('guru.rekap-nilai.index', compact('jadwals'));
    }
}
