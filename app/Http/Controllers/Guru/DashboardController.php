<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\Soal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $mapelId = $guru->mata_pelajaran_id;

        // Hitung total soal & jadwal khusus mata pelajaran guru yang login
        $totalSoal = Soal::where('mata_pelajaran_id', $mapelId)->count();
        $totalBankSoal = $totalSoal;
        $totalJadwal = JadwalUjian::where('mata_pelajaran_id', $mapelId)->count();

        // 5 Jadwal Ujian terbaru milik guru ini
        $jadwal_ujians = JadwalUjian::with('mataPelajaran')
            ->where('mata_pelajaran_id', $mapelId)
            ->latest()
            ->take(5)
            ->get();

        return view('guru.dashboard', compact(
            'totalSoal',
            'totalBankSoal',
            'totalJadwal',
            'jadwal_ujians'
        ));
    }
}
