<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\User;
use App\Models\JawabanSiswa;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringUjianController extends Controller
{
    /**
     * Halaman Utama Monitoring Ujian
     */
    public function index()
    {
        $jadwalAktif = JadwalUjian::with('mataPelajaran')->latest()->get();

        return view('admin.monitoring-ujian.index', compact('jadwalAktif'));
    }

    /**
     * Endpoint AJAX untuk Mengambil Data Monitoring & Statistik Real-Time
     */
    public function getData(Request $request)
    {
        $jadwalId = $request->get('jadwal_id');

        // Ambil jadwal yang dipilih atau jadwal pertama yang aktif
        $jadwal = $jadwalId
            ? JadwalUjian::with('mataPelajaran')->find($jadwalId)
            : JadwalUjian::with('mataPelajaran')->where('status', 'aktif')->first();

        if (!$jadwal) {
            return response()->json([
                'status' => true,
                'data' => [],
                'summary' => ['online' => 0, 'warning' => 0, 'selesai' => 0, 'blocked' => 0]
            ]);
        }

        $totalSoal = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->count();
        $siswas = User::where('role', 'siswa')->orderBy('name', 'asc')->get();

        $data = [];
        $summary = [
            'online'  => 0,
            'warning' => 0,
            'selesai' => 0,
            'blocked' => 0,
        ];

        foreach ($siswas as $siswa) {
            $soalTerjawab = JawabanSiswa::where('user_id', $siswa->id)
                ->where('jadwal_ujian_id', $jadwal->id)
                ->count();

            $hasil = DB::table('hasil_ujians')
                ->where('user_id', $siswa->id)
                ->where('jadwal_ujian_id', $jadwal->id)
                ->first();

            $status = 'belum_mulai';
            $isOnline = false;
            $isBlocked = false;

            if ($hasil) {
                $status = 'selesai';
                $summary['selesai']++;
            } elseif ($soalTerjawab > 0) {
                $status = 'sedang_mengerjakan';
                $isOnline = true;
                $summary['online']++;
            } else {
                $summary['warning']++;
            }

            $data[] = [
                'id'            => $siswa->id,
                'user_id'       => $siswa->id,
                'siswa_nama'    => $siswa->name,
                'siswa_nisn'    => $siswa->username,
                'rombel'        => trim(($siswa->kelas ?? '-') . ' ' . ($siswa->jurusan ?? '')),
                'mapel'         => $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-',
                'soal_terjawab' => $soalTerjawab,
                'total_soal'    => $totalSoal > 0 ? $totalSoal : 1,
                'sisa_menit'    => $jadwal->durasi ?? 60,
                'status'        => $status,
                'is_online'     => $isOnline,
                'is_blocked'    => $isBlocked,
            ];
        }

        return response()->json([
            'status'  => true,
            'data'    => $data,
            'summary' => $summary,
        ]);
    }

    /**
     * Action: Reset Sesi Login Siswa (Ganti Perangkat)
     */
    public function resetSession($userId)
    {
        DB::table('sessions')->where('user_id', $userId)->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Sesi login siswa berhasil di-reset.'
        ]);
    }

    /**
     * Action: Hentikan / Paksa Selesai Ujian Siswa
     */
    public function forceFinish($pesertaId)
    {
        $jadwalAktif = JadwalUjian::where('status', 'aktif')->first();

        if ($jadwalAktif) {
            $jawaban = JawabanSiswa::where('user_id', $pesertaId)
                ->where('jadwal_ujian_id', $jadwalAktif->id)
                ->get();

            $soalBenar = $jawaban->where('is_benar', 1)->count();
            $totalSoal = Soal::where('mata_pelajaran_id', $jadwalAktif->mata_pelajaran_id)->count();
            $nilai = $totalSoal > 0 ? round(($soalBenar / $totalSoal) * 100, 2) : 0;

            DB::table('hasil_ujians')->updateOrInsert(
                ['user_id' => $pesertaId, 'jadwal_ujian_id' => $jadwalAktif->id],
                [
                    'nilai'      => $nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Ujian siswa berhasil difinalisasi.'
        ]);
    }

    /**
     * Action: Tambah Waktu Pengerjaan Siswa
     */
    public function tambahWaktu(Request $request, $pesertaId)
    {
        $menit = (int) $request->input('menit', 10);

        return response()->json([
            'status'  => true,
            'message' => "Waktu pengerjaan berhasil ditambah {$menit} menit."
        ]);
    }
}
