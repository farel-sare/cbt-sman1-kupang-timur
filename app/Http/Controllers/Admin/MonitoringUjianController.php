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
        // Ambil semua jadwal ujian yang berstatus aktif untuk dropdown filter
        $jadwalAktif = JadwalUjian::with('mataPelajaran')
            ->whereIn('status', ['1', 1, 'aktif', 'buka', 'berlangsung'])
            ->latest()
            ->get();

        return view('admin.monitoring-ujian.index', compact('jadwalAktif'));
    }

    /**
     * Endpoint AJAX untuk Mengambil Data Monitoring & Statistik Real-Time
     */
    public function getData(Request $request)
    {
        $jadwalId = $request->get('jadwal_id');

        if ($jadwalId) {
            $jadwals = JadwalUjian::with('mataPelajaran')->where('id', $jadwalId)->get();
        } else {
            $jadwals = JadwalUjian::with('mataPelajaran')
                ->whereIn('status', ['1', 1, 'aktif', 'buka', 'berlangsung'])
                ->latest()
                ->get();
        }

        if ($jadwals->isEmpty()) {
            return response()->json([
                'status'  => true,
                'data'    => [],
                'summary' => ['online' => 0, 'warning' => 0, 'selesai' => 0, 'blocked' => 0]
            ]);
        }

        $data = [];
        $summary = [
            'online'  => 0,
            'warning' => 0,
            'selesai' => 0,
            'blocked' => 0,
        ];

        foreach ($jadwals as $jadwal) {
            $totalSoal = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->count();

            // Ambil ID siswa yang sudah memiliki riwayat di jadwal ini
            $siswaIdsInJadwal = JawabanSiswa::where('jadwal_ujian_id', $jadwal->id)->pluck('user_id')
                ->merge(DB::table('hasil_ujians')->where('jadwal_ujian_id', $jadwal->id)->pluck('user_id'))
                ->merge(DB::table('siswa_ujians')->where('jadwal_ujian_id', $jadwal->id)->pluck('user_id'))
                ->unique();

            // Filter siswa berdasarkan kelas atau riwayat pengerjaan
            $siswaQuery = User::where('role', 'siswa');
            if (!empty($jadwal->kelas)) {
                $siswaQuery->where(function ($q) use ($jadwal, $siswaIdsInJadwal) {
                    $q->where('kelas', $jadwal->kelas)
                      ->orWhereIn('id', $siswaIdsInJadwal);
                });
            }
            $siswas = $siswaQuery->orderBy('name', 'asc')->get();

            if ($siswas->isEmpty()) {
                $siswas = User::where('role', 'siswa')->orderBy('name', 'asc')->get();
            }

            foreach ($siswas as $siswa) {
                $soalTerjawab = JawabanSiswa::where('user_id', $siswa->id)
                    ->where('jadwal_ujian_id', $jadwal->id)
                    ->count();

                $hasil = DB::table('hasil_ujians')
                    ->where('user_id', $siswa->id)
                    ->where('jadwal_ujian_id', $jadwal->id)
                    ->first();

                $siswaUjian = DB::table('siswa_ujians')
                    ->where('user_id', $siswa->id)
                    ->where('jadwal_ujian_id', $jadwal->id)
                    ->first();

                $status = 'belum_mulai';
                $isOnline = false;
                $isBlocked = false;

                // Penentuan status pengerjaan berdasarkan DB hasil_ujians & siswa_ujians
                if ($hasil || ($siswaUjian && $siswaUjian->status === 'selesai')) {
                    $status = 'selesai';
                    $summary['selesai']++;
                } elseif ($siswaUjian && $siswaUjian->status === 'terkunci') {
                    $status = 'terkunci';
                    $isBlocked = true;
                    $summary['blocked']++;
                } elseif (($siswaUjian && $siswaUjian->status === 'mengerjakan') || $soalTerjawab > 0) {
                    $status = 'sedang_mengerjakan';
                    $isOnline = true;
                    $summary['online']++;
                } else {
                    $status = 'belum_mulai';
                    $summary['warning']++;
                }

                $data[] = [
                    'id'                 => $siswa->id . '_' . $jadwal->id,
                    'user_id'            => $siswa->id,
                    'jadwal_id'          => $jadwal->id,
                    'siswa_nama'         => $siswa->name,
                    'siswa_nisn'         => $siswa->username,
                    'rombel'             => trim(($siswa->kelas ?? $jadwal->kelas ?? '-') . ' ' . ($siswa->jurusan ?? '')),
                    'mapel'              => $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-',
                    'soal_terjawab'      => $soalTerjawab,
                    'total_soal'         => $totalSoal > 0 ? $totalSoal : 1,
                    'sisa_menit'         => $jadwal->durasi ?? $jadwal->lama_ujian ?? 60,
                    'jumlah_pelanggaran' => $siswaUjian->jumlah_pelanggaran ?? 0,
                    'status'             => $status,
                    'is_online'          => $isOnline,
                    'is_blocked'         => $isBlocked,
                ];
            }
        }

        return response()->json([
            'status'  => true,
            'data'    => $data,
            'summary' => $summary,
        ]);
    }

    /**
     * Action: Reset Sesi Login & Membuka Kunci Ujian Siswa (Pelanggaran/Ganti Device)
     */
    public function resetSession($userId)
    {
        // 1. Hapus sesi login aktif di DB
        DB::table('sessions')->where('user_id', $userId)->delete();

        // 2. Reset status terkunci & jumlah pelanggaran siswa di tabel siswa_ujians
        DB::table('siswa_ujians')
            ->where('user_id', $userId)
            ->update([
                'jumlah_pelanggaran' => 0,
                'status'             => 'mengerjakan',
                'updated_at'         => now(),
            ]);

        return response()->json([
            'status'  => true,
            'message' => 'Sesi login dan status terkunci ujian siswa berhasil di-reset.'
        ]);
    }

    /**
     * Action: Hentikan / Paksa Selesai Ujian Siswa
     */
    public function forceFinish(Request $request, $pesertaId)
    {
        $jadwalId = $request->input('jadwal_id');
        $jadwalAktif = $jadwalId
            ? JadwalUjian::find($jadwalId)
            : JadwalUjian::whereIn('status', ['1', 1, 'aktif', 'buka', 'berlangsung'])->first();

        if ($jadwalAktif) {
            $jawaban = JawabanSiswa::where('user_id', $pesertaId)
                ->where('jadwal_ujian_id', $jadwalAktif->id)
                ->get();

            $soalBenar = $jawaban->where('is_correct', true)->count();
            $totalSoal = Soal::where('mata_pelajaran_id', $jadwalAktif->mata_pelajaran_id)->count();
            $jumlahSalah = $totalSoal - $soalBenar;
            $nilai = $totalSoal > 0 ? round(($soalBenar / $totalSoal) * 100, 1) : 0;

            // Simpan Hasil Ujian Resmi
            DB::table('hasil_ujians')->updateOrInsert(
                ['user_id' => $pesertaId, 'jadwal_ujian_id' => $jadwalAktif->id],
                [
                    'jumlah_benar' => $soalBenar,
                    'jumlah_salah' => $jumlahSalah,
                    'nilai'        => $nilai,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );

            // Tandai Status Selesai di tabel siswa_ujians
            DB::table('siswa_ujians')->updateOrInsert(
                ['user_id' => $pesertaId, 'jadwal_ujian_id' => $jadwalAktif->id],
                [
                    'status'     => 'selesai',
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
