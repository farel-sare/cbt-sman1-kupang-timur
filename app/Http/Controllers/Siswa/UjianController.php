<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\Soal;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    public function showTokenForm($id)
    {
        $jadwal = JadwalUjian::with('mataPelajaran')->findOrFail($id);

        // Cek apakah ujian sudah dibuka oleh Admin
        if ($jadwal->status !== 'berlangsung') {
            return back()->withErrors(['token' => 'Ujian ini belum dibuka oleh Admin. Silakan tunggu hingga sesi ujian dibuka.']);
        }

        return view('siswa.ujian.token', compact('jadwal'));
    }

    public function verifyToken(Request $request, $id)
    {
        $request->validate(['token' => 'required|string']);
        $jadwal = JadwalUjian::findOrFail($id);

        // 1. Validasi Status Ujian (Wajib Berlangsung)
        if ($jadwal->status !== 'berlangsung') {
            return back()->withErrors(['token' => 'Ujian ini belum dibuka oleh Admin. Silakan tunggu hingga sesi ujian dibuka.']);
        }

        // 2. Validasi Ketersediaan Token Ujian
        if (strtoupper(trim($request->token)) !== strtoupper($jadwal->token)) {
            return back()->withErrors(['token' => 'Token ujian salah atau tidak valid!']);
        }

        session(['active_exam_' . $jadwal->id => true]);

        return redirect()->route('siswa.ujian.room', $jadwal->id)
                         ->with('success', 'Token valid! Selamat mengerjakan.');
    }

    public function room($id)
    {
        $jadwal = JadwalUjian::with('mataPelajaran')->findOrFail($id);

        // Cek jika status ujian dihentikan/ditutup Admin saat siswa di ruang ujian
        if ($jadwal->status !== 'berlangsung') {
            session()->forget('active_exam_' . $id);
            return redirect()->route('siswa.dashboard')
                             ->with('error', 'Sesi ujian telah ditutup oleh Admin.');
        }

        if (!session('active_exam_' . $id)) {
            return redirect()->route('siswa.ujian.token', $id)
                             ->withErrors(['token' => 'Akses ditolak! Masukkan token terlebih dahulu.']);
        }

        $soals = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->get();

        if ($soals->isEmpty()) {
            return back()->withErrors(['token' => 'Soal ujian belum tersedia.']);
        }

        // Ambil jawaban siswa yang sudah pernah tersimpan sebelumnya (jika halaman di-refresh)
        $jawabanSiswa = JawabanSiswa::where('user_id', auth()->id())
                                   ->where('jadwal_ujian_id', $jadwal->id)
                                   ->pluck('jawaban', 'soal_id')
                                   ->toArray();

        return view('siswa.ujian.room', compact('jadwal', 'soals', 'jawabanSiswa'));
    }

    // Process Auto-Save via AJAX
    public function simpanJawaban(Request $request)
    {
        $request->validate([
            'jadwal_ujian_id' => 'required|exists:jadwal_ujians,id',
            'soal_id'         => 'required|exists:soals,id',
            'jawaban'         => 'required|string|in:a,b,c,d,e',
        ]);

        $soal = Soal::findOrFail($request->soal_id);
        $isCorrect = (strtolower(trim($request->jawaban)) === strtolower(trim($soal->kunci_jawaban)));

        JawabanSiswa::updateOrCreate(
            [
                'user_id'         => auth()->id(),
                'jadwal_ujian_id' => $request->jadwal_ujian_id,
                'soal_id'         => $request->soal_id,
            ],
            [
                'jawaban'    => strtolower($request->jawaban),
                'is_correct' => $isCorrect,
            ]
        );

        return response()->json(['status' => 'success', 'message' => 'Jawaban berhasil disimpan.']);
    }

    // Proses Selesai & Penyimpanan Skor ke tabel hasil_ujians
    public function selesaiUjian(Request $request, $id)
    {
        $jadwal = JadwalUjian::findOrFail($id);

        $totalSoal = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->count();
        $jumlahBenar = JawabanSiswa::where('user_id', auth()->id())
                                    ->where('jadwal_ujian_id', $jadwal->id)
                                    ->where('is_correct', true)
                                    ->count();
        $jumlahSalah = $totalSoal - $jumlahBenar;

        // Kalkulasi Skor Nilai (Skala 100)
        $nilai = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 1) : 0;

        // Simpan Hasil Ujian Siswa ke Tabel hasil_ujians menggunakan updateOrInsert
        DB::table('hasil_ujians')->updateOrInsert(
            [
                'user_id'         => auth()->id(),
                'jadwal_ujian_id' => $jadwal->id,
            ],
            [
                'jumlah_benar' => $jumlahBenar,
                'jumlah_salah' => $jumlahSalah,
                'nilai'        => $nilai,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        );

        // Hapus sesi aktif ujian
        session()->forget('active_exam_' . $id);

        return redirect()->route('siswa.ujian.hasil', $id)
                         ->with('success', 'Ujian telah berhasil diselesaikan!');
    }

    // Halaman Hasil Ujian
    public function hasilUjian($id)
    {
        $jadwal = JadwalUjian::with('mataPelajaran')->findOrFail($id);

        // Ambil data nilai resmi dari tabel hasil_ujians
        $hasil = DB::table('hasil_ujians')
                    ->where('user_id', auth()->id())
                    ->where('jadwal_ujian_id', $jadwal->id)
                    ->first();

        $totalSoal = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->count();
        $jawabanBenar = $hasil->jumlah_benar ?? 0;
        $nilai = $hasil->nilai ?? 0;

        return view('siswa.ujian.hasil', compact('jadwal', 'totalSoal', 'jawabanBenar', 'nilai'));
    }
}
