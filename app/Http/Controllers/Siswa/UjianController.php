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
    /**
     * Halaman Input Token Ujian
     */
    public function showTokenForm($id)
    {
        $jadwal = JadwalUjian::with('mataPelajaran')->findOrFail($id);
        $userId = auth()->id();

        // 1. Cek apakah ujian aktif
        if (!in_array($jadwal->status, ['1', 1, 'aktif', 'buka', 'berlangsung'])) {
            return back()->withErrors(['token' => 'Ujian ini belum dibuka oleh Admin/Guru. Silakan tunggu hingga sesi ujian dibuka.']);
        }

        // 2. Cek apakah siswa sudah selesai / terkunci
        $hasil = DB::table('hasil_ujians')->where('user_id', $userId)->where('jadwal_ujian_id', $id)->first();
        $siswaUjian = DB::table('siswa_ujians')->where('user_id', $userId)->where('jadwal_ujian_id', $id)->first();

        if ($hasil || ($siswaUjian && $siswaUjian->status === 'selesai')) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda telah menyelesaikan ujian ini dan tidak dapat mengerjakan ulang.');
        }

        if ($siswaUjian && $siswaUjian->status === 'terkunci') {
            return redirect()->route('siswa.dashboard')->with('error', 'Ujian Anda TERKUNCI karena pelanggaran. Silakan hubungi Admin/Pengawas untuk mereset sesi.');
        }

        return view('siswa.ujian.token', compact('jadwal'));
    }

    /**
     * Verifikasi Token Ujian
     */
    public function verifyToken(Request $request, $id)
    {
        $request->validate(['token' => 'required|string']);
        $jadwal = JadwalUjian::findOrFail($id);
        $userId = auth()->id();

        // 1. Validasi Status Ujian (Wajib Aktif)
        if (!in_array($jadwal->status, ['1', 1, 'aktif', 'buka', 'berlangsung'])) {
            return back()->withErrors(['token' => 'Ujian ini belum dibuka oleh Admin/Guru. Silakan tunggu hingga sesi ujian dibuka.']);
        }

        // 2. Cek Apakah Siswa Sudah Selesai atau Terkunci
        $hasil = DB::table('hasil_ujians')->where('user_id', $userId)->where('jadwal_ujian_id', $id)->first();
        $siswaUjian = DB::table('siswa_ujians')->where('user_id', $userId)->where('jadwal_ujian_id', $id)->first();

        if ($hasil || ($siswaUjian && $siswaUjian->status === 'selesai')) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda telah menyelesaikan ujian ini.');
        }

        if ($siswaUjian && $siswaUjian->status === 'terkunci') {
            return redirect()->route('siswa.dashboard')->with('error', 'Ujian Anda TERKUNCI karena pelanggaran. Silakan hubungi Admin/Pengawas.');
        }

        // 3. Validasi Token Ujian
        if (strtoupper(trim($request->token)) !== strtoupper(trim($jadwal->token))) {
            return back()->withErrors(['token' => 'Token ujian salah atau tidak valid!']);
        }

        session(['active_exam_' . $jadwal->id => true]);

        // Tandai status siswa sedang mengerjakan
        DB::table('siswa_ujians')->updateOrInsert(
            ['user_id' => $userId, 'jadwal_ujian_id' => $id],
            ['status' => 'mengerjakan', 'updated_at' => now()]
        );

        return redirect()->route('siswa.ujian.room', $jadwal->id)
                         ->with('success', 'Token valid! Selamat mengerjakan.');
    }

    /**
     * Ruang Ujian Siswa
     */
    public function room($id)
    {
        $jadwal = JadwalUjian::with('mataPelajaran')->findOrFail($id);
        $userId = auth()->id();

        // Cek jika status ujian dihentikan/ditutup Admin saat siswa di ruang ujian
        if (!in_array($jadwal->status, ['1', 1, 'aktif', 'buka', 'berlangsung'])) {
            session()->forget('active_exam_' . $id);
            return redirect()->route('siswa.dashboard')->with('error', 'Sesi ujian telah ditutup oleh Admin/Guru.');
        }

        // Cek apakah siswa sudah selesai atau terkunci
        $hasil = DB::table('hasil_ujians')->where('user_id', $userId)->where('jadwal_ujian_id', $id)->first();
        $siswaUjian = DB::table('siswa_ujians')->where('user_id', $userId)->where('jadwal_ujian_id', $id)->first();

        if ($hasil || ($siswaUjian && $siswaUjian->status === 'selesai')) {
            session()->forget('active_exam_' . $id);
            return redirect()->route('siswa.dashboard')->with('error', 'Anda telah menyelesaikan ujian ini.');
        }

        if ($siswaUjian && $siswaUjian->status === 'terkunci') {
            session()->forget('active_exam_' . $id);
            return redirect()->route('siswa.dashboard')->with('error', 'Ujian Anda TERKUNCI karena pelanggaran. Silakan hubungi Admin/Pengawas.');
        }

        if (!session('active_exam_' . $id)) {
            return redirect()->route('siswa.ujian.token', $id)
                             ->withErrors(['token' => 'Akses ditolak! Masukkan token terlebih dahulu.']);
        }

        $soals = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->get();

        if ($soals->isEmpty()) {
            return back()->withErrors(['token' => 'Soal ujian belum tersedia.']);
        }

        // Ambil jawaban siswa yang sudah pernah tersimpan sebelumnya
        $jawabanSiswa = JawabanSiswa::where('user_id', $userId)
                                   ->where('jadwal_ujian_id', $jadwal->id)
                                   ->pluck('jawaban', 'soal_id')
                                   ->toArray();

        return view('siswa.ujian.room', compact('jadwal', 'soals', 'jawabanSiswa'));
    }

    /**
     * Process Auto-Save Jawaban via AJAX
     */
    public function simpanJawaban(Request $request)
    {
        $request->validate([
            'jadwal_ujian_id' => 'required|exists:jadwal_ujians,id',
            'soal_id'         => 'required|exists:soals,id',
            'jawaban'         => 'required|string|in:a,b,c,d,e,A,B,C,D,E',
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

    /**
     * Process Anti-Cheat: Pencatatan Pelanggaran Pindah Tab
     */
    public function catatPelanggaran(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_ujians,id',
        ]);

        $userId = auth()->id();
        $jadwalId = $request->input('jadwal_id');
        $maxPelanggaran = 3; // Batas toleransi pindah tab

        $siswaUjian = DB::table('siswa_ujians')
            ->where('user_id', $userId)
            ->where('jadwal_ujian_id', $jadwalId)
            ->first();

        $jumlahPelanggaran = ($siswaUjian->jumlah_pelanggaran ?? 0) + 1;
        $status = ($jumlahPelanggaran >= $maxPelanggaran) ? 'terkunci' : 'mengerjakan';

        DB::table('siswa_ujians')->updateOrInsert(
            ['user_id' => $userId, 'jadwal_ujian_id' => $jadwalId],
            [
                'jumlah_pelanggaran' => $jumlahPelanggaran,
                'status'             => $status,
                'updated_at'         => now(),
            ]
        );

        return response()->json([
            'status'             => true,
            'jumlah_pelanggaran' => $jumlahPelanggaran,
            'max_pelanggaran'    => $maxPelanggaran,
            'is_locked'          => $jumlahPelanggaran >= $maxPelanggaran,
            'message'            => $jumlahPelanggaran >= $maxPelanggaran
                ? 'Ujian Anda telah terkunci karena melebihi batas pelanggaran! Silakan lapor ke Admin.'
                : "Peringatan! Jangan meninggalkan halaman ujian ({$jumlahPelanggaran}/{$maxPelanggaran})."
        ]);
    }

    /**
     * Proses Selesai & Penyimpanan Skor ke tabel hasil_ujians
     */
    public function selesaiUjian(Request $request, $id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        $userId = auth()->id();

        $totalSoal = Soal::where('mata_pelajaran_id', $jadwal->mata_pelajaran_id)->count();
        $jumlahBenar = JawabanSiswa::where('user_id', $userId)
                                    ->where('jadwal_ujian_id', $jadwal->id)
                                    ->where('is_correct', true)
                                    ->count();
        $jumlahSalah = $totalSoal - $jumlahBenar;

        // Kalkulasi Skor Nilai (Skala 100)
        $nilai = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100, 1) : 0;

        // Simpan Hasil Ujian Siswa ke Tabel hasil_ujians
        DB::table('hasil_ujians')->updateOrInsert(
            [
                'user_id'         => $userId,
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

        // Update status sesi siswa menjadi selesai
        DB::table('siswa_ujians')->updateOrInsert(
            ['user_id' => $userId, 'jadwal_ujian_id' => $jadwal->id],
            ['status' => 'selesai', 'updated_at' => now()]
        );

        // Hapus sesi aktif ujian
        session()->forget('active_exam_' . $id);

        return redirect()->route('siswa.ujian.hasil', $id)
                         ->with('success', 'Ujian telah berhasil diselesaikan!');
    }

    /**
     * Halaman Hasil Ujian
     */
    public function hasilUjian($id)
    {
        $jadwal = JadwalUjian::with('mataPelajaran')->findOrFail($id);

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
