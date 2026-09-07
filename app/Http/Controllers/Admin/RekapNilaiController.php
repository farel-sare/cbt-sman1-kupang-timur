<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapNilaiController extends Controller
{
    public function index(Request $request)
    {
        $jadwalUjians = JadwalUjian::with('mataPelajaran')->latest()->get();
        $selectedJadwalId = $request->get('jadwal_ujian_id');
        $selectedKelas = $request->get('kelas');
        $selectedJurusan = $request->get('jurusan');

        // Mengambil daftar opsi Kelas dan Jurusan unik dari database siswa
        $listKelas = User::where('role', 'siswa')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->pluck('kelas')
            ->sort();

        $listJurusan = User::where('role', 'siswa')
            ->whereNotNull('jurusan')
            ->where('jurusan', '!=', '')
            ->distinct()
            ->pluck('jurusan')
            ->sort();

        $selectedJadwal = null;
        $hasilUjians = collect();

        if ($selectedJadwalId) {
            $selectedJadwal = JadwalUjian::with('mataPelajaran')->find($selectedJadwalId);

            $query = DB::table('hasil_ujians')
                ->join('users', 'hasil_ujians.user_id', '=', 'users.id')
                ->where('hasil_ujians.jadwal_ujian_id', $selectedJadwalId)
                ->select(
                    'users.name as nama_siswa',
                    'users.username as nisn',
                    'users.kelas',
                    'users.jurusan',
                    'hasil_ujians.jumlah_benar',
                    'hasil_ujians.jumlah_salah',
                    'hasil_ujians.nilai',
                    'hasil_ujians.created_at as waktu_selesai'
                );

            // Filter berdasarkan Kelas jika dipilih
            if ($selectedKelas) {
                $query->where('users.kelas', $selectedKelas);
            }

            // Filter berdasarkan Jurusan jika dipilih
            if ($selectedJurusan) {
                $query->where('users.jurusan', $selectedJurusan);
            }

            $hasilUjians = $query->orderBy('users.name', 'asc')->get();
        }

        return view('admin.rekap-nilai.index', compact(
            'jadwalUjians',
            'selectedJadwalId',
            'selectedKelas',
            'selectedJurusan',
            'listKelas',
            'listJurusan',
            'selectedJadwal',
            'hasilUjians'
        ));
    }

    public function cetak(Request $request)
    {
        $selectedJadwalId = $request->get('jadwal_ujian_id');
        $selectedKelas = $request->get('kelas');
        $selectedJurusan = $request->get('jurusan');

        $selectedJadwal = JadwalUjian::with('mataPelajaran')->findOrFail($selectedJadwalId);

        $query = DB::table('hasil_ujians')
            ->join('users', 'hasil_ujians.user_id', '=', 'users.id')
            ->where('hasil_ujians.jadwal_ujian_id', $selectedJadwalId)
            ->select(
                'users.name as nama_siswa',
                'users.username as nisn',
                'users.kelas',
                'users.jurusan',
                'hasil_ujians.jumlah_benar',
                'hasil_ujians.jumlah_salah',
                'hasil_ujians.nilai',
                'hasil_ujians.created_at as waktu_selesai'
            );

        if ($selectedKelas) {
            $query->where('users.kelas', $selectedKelas);
        }

        if ($selectedJurusan) {
            $query->where('users.jurusan', $selectedJurusan);
        }

        $hasilUjians = $query->orderBy('users.name', 'asc')->get();

        return view('admin.rekap-nilai.cetak', compact('selectedJadwal', 'hasilUjians', 'selectedKelas', 'selectedJurusan'));
    }

    public function export(Request $request)
{
    $selectedJadwalId = $request->get('jadwal_ujian_id');
    $selectedKelas = $request->get('kelas');
    $selectedJurusan = $request->get('jurusan');

    $selectedJadwal = JadwalUjian::with('mataPelajaran')->findOrFail($selectedJadwalId);

    $query = DB::table('hasil_ujians')
        ->join('users', 'hasil_ujians.user_id', '=', 'users.id')
        ->where('hasil_ujians.jadwal_ujian_id', $selectedJadwalId)
        ->select(
            'users.name as nama_siswa',
            'users.username as nisn',
            'users.kelas',
            'users.jurusan',
            'hasil_ujians.jumlah_benar',
            'hasil_ujians.jumlah_salah',
            'hasil_ujians.nilai',
            'hasil_ujians.created_at as waktu_selesai'
        );

    if ($selectedKelas) {
        $query->where('users.kelas', $selectedKelas);
    }

    if ($selectedJurusan) {
        $query->where('users.jurusan', $selectedJurusan);
    }

    $hasilUjians = $query->orderBy('users.name', 'asc')->get();

    $fileName = 'Rekap_Nilai_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $selectedJadwal->judul) . '.csv';

    $headers = [
        "Content-type"        => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $callback = function() use ($hasilUjians) {
        $file = fopen('php://output', 'w');

        // Menambahkan UTF-8 BOM agar file CSV langsung rapi dibaca Excel tanpa karakter aneh
        fputs($file, "\xEF\xBB\xBF");

        // Header Kolom Tabel
        fputcsv($file, ['No', 'Nama Siswa', 'NISN', 'Kelas', 'Jurusan', 'Jumlah Benar', 'Jumlah Salah', 'Nilai Akhir', 'Waktu Selesai']);

        foreach ($hasilUjians as $index => $row) {
            fputcsv($file, [
                $index + 1,
                $row->nama_siswa,
                "'" . $row->nisn, // Tanda petik tunggal mencegah angka NISN diubah menjadi format scientific oleh Excel
                $row->kelas ?? '-',
                $row->jurusan ?? '-',
                $row->jumlah_benar,
                $row->jumlah_salah,
                $row->nilai,
                \Carbon\Carbon::parse($row->waktu_selesai)->format('d/m/Y H:i')
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}
