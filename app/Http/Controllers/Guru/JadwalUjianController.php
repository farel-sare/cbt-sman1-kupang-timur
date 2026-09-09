<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $jadwal_ujians = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)
            ->latest()
            ->paginate(10);

        return view('guru.jadwal-ujian.index', compact('jadwal_ujians'));
    }

    public function store(Request $request)
    {
        $guru = auth()->user();

        $request->validate([
            'nama_ujian'  => 'required|string|max:255',
            'kelas'       => 'required|string',
            'lama_ujian'  => 'required|numeric|min:5',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        JadwalUjian::create([
            'judul'             => $request->nama_ujian,
            'mata_pelajaran_id' => $guru->mata_pelajaran_id,
            'kelas'             => $request->kelas,
            'tanggal'           => $request->tgl_mulai,
            'durasi'            => $request->lama_ujian,
            'token'             => strtoupper(Str::random(6)),
            'status'            => '1',
        ]);

        return redirect()->route('guru.jadwal-ujian.index')->with('success', 'Jadwal ujian berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $guru = auth()->user();
        $jadwal = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)->findOrFail($id);

        $request->validate([
            'nama_ujian'  => 'required|string|max:255',
            'kelas'       => 'required|string',
            'lama_ujian'  => 'required|numeric|min:5',
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $jadwal->update([
            'judul'   => $request->nama_ujian,
            'kelas'   => $request->kelas,
            'durasi'  => $request->lama_ujian,
            'tanggal' => $request->tgl_mulai,
        ]);

        return redirect()->route('guru.jadwal-ujian.index')->with('success', 'Jadwal ujian berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = auth()->user();
        $jadwal = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)->findOrFail($id);
        $jadwal->delete();

        return redirect()->route('guru.jadwal-ujian.index')->with('success', 'Jadwal ujian berhasil dihapus!');
    }

    public function generateToken($id)
    {
        $guru = auth()->user();
        $jadwal = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)->findOrFail($id);
        $jadwal->update(['token' => strtoupper(Str::random(6))]);

        return redirect()->back()->with('success', 'Token baru berhasil dibuat: ' . $jadwal->token);
    }

    public function toggleStatus($id)
    {
        $guru = auth()->user();
        $jadwal = JadwalUjian::where('mata_pelajaran_id', $guru->mata_pelajaran_id)->findOrFail($id);
        $newStatus = in_array($jadwal->status, ['1', 'aktif', 'buka']) ? '0' : '1';
        $jadwal->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status ujian berhasil diubah!');
    }
}
