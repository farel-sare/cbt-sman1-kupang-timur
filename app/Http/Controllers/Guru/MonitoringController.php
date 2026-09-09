<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;

class MonitoringController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $jadwals = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)
            ->whereIn('status', ['1', 'aktif', 'buka'])
            ->get();

        return view('guru.monitoring.index', compact('jadwals'));
    }
}
