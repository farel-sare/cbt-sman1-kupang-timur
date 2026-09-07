<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    /**
     * Menampilkan daftar bank soal khusus mata pelajaran guru yang login.
     */
    public function index(Request $request)
    {
        $guru = auth()->user();
        $mapelId = $guru->mata_pelajaran_id;
        $search = $request->get('search');

        // Fetch soal berdasarkan mapel guru & pencarian
        $soals = Soal::with('mataPelajaran')
            ->when($mapelId, function ($query) use ($mapelId) {
                return $query->where('mata_pelajaran_id', $mapelId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('pertanyaan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        $mapelGuru = MataPelajaran::find($mapelId);

        return view('guru.bank-soal.index', compact('soals', 'mapelGuru', 'search'));
    }

    /**
     * Menyimpan butir soal baru.
     */
    public function store(Request $request)
    {
        $guru = auth()->user();

        // Cek apakah guru sudah diatur mata pelajarannya
        if (!$guru->mata_pelajaran_id) {
            return redirect()->back()->withErrors(['mata_pelajaran' => 'Akun Anda belum terhubung dengan Mata Pelajaran apapun. Hubungi Admin.']);
        }

        $request->validate([
            'pertanyaan'    => 'required|string',
            'opsi_a'        => 'required|string',
            'opsi_b'        => 'required|string',
            'opsi_c'        => 'required|string',
            'opsi_d'        => 'required|string',
            'opsi_e'        => 'nullable|string',
            'kunci_jawaban' => 'required|in:A,B,C,D,E',
        ], [
            'pertanyaan.required'    => 'Pertanyaan soal wajib diisi.',
            'opsi_a.required'        => 'Opsi A wajib diisi.',
            'opsi_b.required'        => 'Opsi B wajib diisi.',
            'opsi_c.required'        => 'Opsi C wajib diisi.',
            'opsi_d.required'        => 'Opsi D wajib diisi.',
            'kunci_jawaban.required' => 'Kunci jawaban wajib dipilih.',
        ]);

        Soal::create([
            'mata_pelajaran_id' => $guru->mata_pelajaran_id,
            'pertanyaan'        => $request->pertanyaan,
            'opsi_a'            => $request->opsi_a,
            'opsi_b'            => $request->opsi_b,
            'opsi_c'            => $request->opsi_c,
            'opsi_d'            => $request->opsi_d,
            'opsi_e'            => $request->opsi_e,
            'kunci_jawaban'     => $request->kunci_jawaban,
        ]);

        return redirect()->route('guru.bank-soal.index')->with('success', 'Soal berhasil ditambahkan ke Bank Soal!');
    }

    /**
     * Memperbarui butir soal.
     */
    public function update(Request $request, $id)
    {
        $guru = auth()->user();

        // Memastikan soal yang diedit adalah milik mapel guru ini
        $soal = Soal::where('mata_pelajaran_id', $guru->mata_pelajaran_id)->findOrFail($id);

        $request->validate([
            'pertanyaan'    => 'required|string',
            'opsi_a'        => 'required|string',
            'opsi_b'        => 'required|string',
            'opsi_c'        => 'required|string',
            'opsi_d'        => 'required|string',
            'opsi_e'        => 'nullable|string',
            'kunci_jawaban' => 'required|in:A,B,C,D,E',
        ]);

        $soal->update([
            'pertanyaan'    => $request->pertanyaan,
            'opsi_a'        => $request->opsi_a,
            'opsi_b'        => $request->opsi_b,
            'opsi_c'        => $request->opsi_c,
            'opsi_d'        => $request->opsi_d,
            'opsi_e'        => $request->opsi_e,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return redirect()->route('guru.bank-soal.index')->with('success', 'Soal berhasil diperbarui!');
    }

    /**
     * Menghapus butir soal.
     */
    public function destroy($id)
    {
        $guru = auth()->user();

        $soal = Soal::where('mata_pelajaran_id', $guru->mata_pelajaran_id)->findOrFail($id);
        $soal->delete();

        return redirect()->route('guru.bank-soal.index')->with('success', 'Soal berhasil dihapus!');
    }
}
