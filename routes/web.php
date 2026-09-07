<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\JadwalUjianController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\RekapNilaiController;
use App\Http\Controllers\Admin\MonitoringUjianController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\BankSoalController as GuruBankSoalController;
use App\Http\Controllers\Siswa\UjianController;
use App\Models\JadwalUjian;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// RUTE KHUSUS ADMINISTRATOR (role: admin)
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        $jadwal_ujians = JadwalUjian::with('mataPelajaran')->latest()->get();
        $totalSiswa = \App\Models\User::where('role', 'siswa')->count();
        $totalGuru = \App\Models\User::where('role', 'guru')->count();
        $totalSoal = \App\Models\Soal::count();
        $totalBankSoal = $totalSoal;

        // Hitung total ujian hari ini
        $totalUjianHariIni = JadwalUjian::whereDate('created_at', now()->toDateString())
            ->orWhereDate('updated_at', now()->toDateString())
            ->count();

        // Ambil sesi ujian yang sedang aktif / dibuka
        $ujianBerlangsung = JadwalUjian::with('mataPelajaran')
            ->whereIn('status', ['aktif', 'buka', '1', 1])
            ->latest()
            ->first();

        // Fallback jika tidak ada status aktif spesifik, ambil jadwal paling terbaru
        if (!$ujianBerlangsung) {
            $ujianBerlangsung = $jadwal_ujians->first();
        }

        return view('admin.dashboard', compact(
            'jadwal_ujians',
            'totalSiswa',
            'totalGuru',
            'totalSoal',
            'totalBankSoal',
            'totalUjianHariIni',
            'ujianBerlangsung'
        ));
    })->name('admin.dashboard');

    // Manajemen Data Guru Admin
    Route::get('/admin/guru', [GuruController::class, 'index'])->name('admin.guru.index');
    Route::post('/admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::put('/admin/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    // Manajemen Data Siswa Admin
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
    Route::post('/admin/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/admin/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    // Manajemen Bank Soal Admin & Import
    Route::get('/admin/bank-soal', [BankSoalController::class, 'index'])->name('admin.bank-soal.index');
    Route::get('/admin/bank-soal/tambah', [BankSoalController::class, 'create'])->name('admin.bank-soal.create');
    Route::post('/admin/bank-soal', [BankSoalController::class, 'store'])->name('admin.bank-soal.store');
    Route::get('/admin/bank-soal/detail/{mata_pelajaran_id}', [BankSoalController::class, 'detail'])->name('admin.bank-soal.detail');
    Route::get('/admin/bank-soal/{soal}/edit', [BankSoalController::class, 'edit'])->name('admin.bank-soal.edit');
    Route::put('/admin/bank-soal/{soal}', [BankSoalController::class, 'update'])->name('admin.bank-soal.update');
    Route::post('/admin/bank-soal/import', [BankSoalController::class, 'import'])->name('admin.bank-soal.import');
    Route::get('/admin/bank-soal/download-template', [BankSoalController::class, 'downloadTemplate'])->name('admin.bank-soal.download-template');
    Route::delete('/admin/bank-soal/{soal}', [BankSoalController::class, 'destroy'])->name('admin.bank-soal.destroy');

    // Manajemen Jadwal Ujian Admin, Token, & Buka/Tutup Ujian
    Route::get('/admin/jadwal-ujian', [JadwalUjianController::class, 'index'])->name('admin.jadwal-ujian.index');
    Route::get('/admin/jadwal-ujian/tambah', [JadwalUjianController::class, 'create'])->name('admin.jadwal-ujian.create');
    Route::post('/admin/jadwal-ujian', [JadwalUjianController::class, 'store'])->name('admin.jadwal-ujian.store');
    Route::get('/admin/jadwal-ujian/{id}/edit', [JadwalUjianController::class, 'edit'])->name('admin.jadwal-ujian.edit');
    Route::put('/admin/jadwal-ujian/{id}', [JadwalUjianController::class, 'update'])->name('admin.jadwal-ujian.update');
    Route::delete('/admin/jadwal-ujian/{id}', [JadwalUjianController::class, 'destroy'])->name('admin.jadwal-ujian.destroy');
    Route::post('/admin/jadwal-ujian/{id}/generate-token', [JadwalUjianController::class, 'generateToken'])->name('admin.jadwal-ujian.generate-token');
    Route::post('/admin/jadwal-ujian/{id}/toggle-status', [JadwalUjianController::class, 'toggleStatus'])->name('admin.jadwal-ujian.toggle-status');

    // Monitoring Ujian Siswa Realtime & Reset Status
    Route::get('/admin/monitoring-ujian', [MonitoringUjianController::class, 'index'])->name('admin.monitoring-ujian.index');
    Route::get('/admin/monitoring-data', [MonitoringUjianController::class, 'getData'])->name('admin.monitoring.data');
    Route::post('/admin/user/reset-session/{userId}', [MonitoringUjianController::class, 'resetSession'])->name('admin.user.reset-session');
    Route::post('/admin/monitoring/force-finish/{pesertaId}', [MonitoringUjianController::class, 'forceFinish'])->name('admin.monitoring.force-finish');
    Route::post('/admin/monitoring/tambah-waktu/{pesertaId}', [MonitoringUjianController::class, 'tambahWaktu'])->name('admin.monitoring.tambah-waktu');

    // Rekap Nilai Admin
    Route::get('/admin/rekap-nilai', [RekapNilaiController::class, 'index'])->name('admin.rekap-nilai.index');
    Route::get('/admin/rekap-nilai/cetak', [RekapNilaiController::class, 'cetak'])->name('admin.rekap-nilai.cetak');
    Route::get('/admin/rekap-nilai/export', [RekapNilaiController::class, 'export'])->name('admin.rekap-nilai.export');
});

// ==========================================
// RUTE KHUSUS GURU (role: guru)
// ==========================================
Route::middleware(['auth', 'role:guru'])->group(function () {

    // Dashboard Guru
    Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');

    // Bank Soal Guru
    Route::get('/guru/bank-soal', [GuruBankSoalController::class, 'index'])->name('guru.bank-soal.index');
    Route::post('/guru/bank-soal', [GuruBankSoalController::class, 'store'])->name('guru.bank-soal.store');
    Route::put('/guru/bank-soal/{soal}', [GuruBankSoalController::class, 'update'])->name('guru.bank-soal.update');
    Route::delete('/guru/bank-soal/{soal}', [GuruBankSoalController::class, 'destroy'])->name('guru.bank-soal.destroy');
});

// ==========================================
// RUTE KHUSUS SISWA (role: siswa)
// ==========================================
Route::middleware(['auth', 'role:siswa'])->group(function () {

    // Dashboard Siswa
    Route::get('/siswa/dashboard', function () {
        $jadwal_ujians = JadwalUjian::with('mataPelajaran')->latest()->get();
        return view('siswa.dashboard', compact('jadwal_ujians'));
    })->name('siswa.dashboard');

    // Rute Ujian Siswa (Verifikasi Token & Ruang Ujian)
    Route::get('/siswa/ujian/{jadwal}/token', [UjianController::class, 'showTokenForm'])->name('siswa.ujian.token');
    Route::post('/siswa/ujian/{jadwal}/verify', [UjianController::class, 'verifyToken'])->name('siswa.ujian.verify');
    Route::get('/siswa/ujian/{jadwal}/room', [UjianController::class, 'room'])->name('siswa.ujian.room');

    // Auto-Save, Selesai, dan Hasil Ujian
    Route::post('/siswa/ujian/simpan-jawaban', [UjianController::class, 'simpanJawaban'])->name('siswa.ujian.simpan-jawaban');
    Route::post('/siswa/ujian/{jadwal}/selesai', [UjianController::class, 'selesaiUjian'])->name('siswa.ujian.selesai');
    Route::get('/siswa/ujian/{jadwal}/hasil', [UjianController::class, 'hasilUjian'])->name('siswa.ujian.hasil');
});

require __DIR__.'/auth.php';
