<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $jadwalUjians = JadwalUjian::with('mataPelajaran')->latest()->paginate(10);
        return view('admin.jadwal-ujian.index', compact('jadwalUjians'));
    }

    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        $token = strtoupper(Str::random(6));

        return view('admin.jadwal-ujian.create', compact('mataPelajarans', 'token'));
    }

public function store(Request $request)
{
    $request->validate([
        'judul'             => 'required|string|max:255',
        'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        'kelas'             => 'required|string',
        'tanggal'           => 'required|date',
        'durasi'            => 'required|integer|min:1',
    ]);

    JadwalUjian::create([
        'judul'             => $request->judul,
        'mata_pelajaran_id' => $request->mata_pelajaran_id,
        'kelas'             => $request->kelas,
        'tanggal'           => $request->tanggal,
        'durasi'            => $request->durasi,
        'token'             => $request->token ?? strtoupper(Str::random(6)),
        'status'            => 'belum_mulai',
    ]);

    return redirect()->route('admin.jadwal-ujian.index')->with('success', 'Jadwal ujian berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    $jadwal = JadwalUjian::findOrFail($id);

    $request->validate([
        'judul'             => 'required|string|max:255',
        'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        'kelas'             => 'required|string',
        'tanggal'           => 'required|date',
        'durasi'            => 'required|integer|min:1',
    ]);

    $jadwal->update([
        'judul'             => $request->judul,
        'mata_pelajaran_id' => $request->mata_pelajaran_id,
        'kelas'             => $request->kelas,
        'tanggal'           => $request->tanggal,
        'durasi'            => $request->durasi,
    ]);

    return redirect()->route('admin.jadwal-ujian.index')->with('success', 'Jadwal ujian berhasil diperbarui!');
}

    public function destroy($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-ujian.index')->with('success', 'Jadwal ujian berhasil dihapus!');
    }

    public function generateToken($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        $jadwal->update([
            'token' => strtoupper(Str::random(6)),
        ]);

        return redirect()->back()->with('success', 'Token ujian berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);

        if ($jadwal->status === 'berlangsung') {
            $jadwal->update(['status' => 'selesai']);
            $message = 'Sesi ujian ' . $jadwal->judul . ' berhasil ditutup/dihentikan.';
        } else {
            $jadwal->update(['status' => 'berlangsung']);
            $message = 'Ujian ' . $jadwal->judul . ' BERHASIL DIBUKA! Siswa sekarang dapat memasukkan token untuk ujian.';
        }

        return redirect()->back()->with('success', $message);
    }
}
