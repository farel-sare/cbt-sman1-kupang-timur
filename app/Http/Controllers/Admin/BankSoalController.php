<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kelas aktif dari request (default kelas 10 jika tidak ada)
        $kelasAktif = $request->input('kelas');

        // Query dasar Mata Pelajaran dengan menghitung jumlah soal per kelas
        $mataPelajarans = MataPelajaran::withCount(['soals' => function($query) use ($kelasAktif) {
            if ($kelasAktif) {
                $query->where('kelas', $kelasAktif);
            }
        }])->get();

        // Hitung total counter untuk tab atas
        $countSemua   = Soal::count();
        $countKelas10 = Soal::where('kelas', '10')->count();
        $countKelas11 = Soal::where('kelas', '11')->count();
        $countKelas12 = Soal::where('kelas', '12')->count();

        return view('admin.bank-soal.index', compact(
            'mataPelajarans',
            'kelasAktif',
            'countSemua',
            'countKelas10',
            'countKelas11',
            'countKelas12'
        ));
    }

    public function detail(Request $request, $mata_pelajaran_id)
    {
        $mapel = MataPelajaran::findOrFail($mata_pelajaran_id);
        $query = Soal::where('mata_pelajaran_id', $mata_pelajaran_id);

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $soals = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bank-soal.detail', compact('mapel', 'soals'));
    }

    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        return view('admin.bank-soal.create', compact('mataPelajarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas'             => 'required|in:10,11,12',
            'pertanyaan'        => 'required|string',
            'opsi_a'            => 'required|string',
            'opsi_b'            => 'required|string',
            'opsi_c'            => 'required|string',
            'opsi_d'            => 'required|string',
            'opsi_e'            => 'nullable|string',
            'kunci_jawaban'     => 'required|in:a,b,c,d,e',
        ]);

        Soal::create($request->all());

        return redirect()->route('admin.bank-soal.index')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file'              => 'required|mimes:csv,txt|max:2048',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas'             => 'required|in:10,11,12',
        ], [
            'file.required'              => 'Pilih file CSV terlebih dahulu.',
            'file.mimes'                 => 'Format file harus berupa CSV.',
            'mata_pelajaran_id.required' => 'Pilih mata pelajaran terlebih dahulu.',
            'kelas.required'             => 'Pilih tingkat kelas terlebih dahulu.',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        fgetcsv($handle, 1000, ',');

        $importedCount = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (!empty($row[0])) {
                Soal::create([
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'kelas'             => $request->kelas,
                    'pertanyaan'        => $row[0],
                    'opsi_a'            => $row[1] ?? '',
                    'opsi_b'            => $row[2] ?? '',
                    'opsi_c'            => $row[3] ?? '',
                    'opsi_d'            => $row[4] ?? '',
                    'opsi_e'            => $row[5] ?? '',
                    'kunci_jawaban'     => strtolower(trim($row[6] ?? 'a')),
                ]);
                $importedCount++;
            }
        }

        fclose($handle);

        return redirect()->back()->with('success', "Berhasil mengimpor {$importedCount} soal untuk Kelas {$request->kelas}!");
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_soal.csv"',
        ];

        $columns = ['Pertanyaan', 'Opsi A', 'Opsi B', 'Opsi C', 'Opsi D', 'Opsi E', 'Kunci Jawaban'];

        $samples = [
            ['Ibu kota Negara Indonesia yang baru adalah...', 'Jakarta', 'Nusantara', 'Surabaya', 'Bandung', 'Medan', 'b'],
            ['Hasil dari 15 + 25 x 2 adalah...', '65', '80', '50', '75', '100', 'a'],
        ];

        $callback = function() use ($columns, $samples) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($samples as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Soal $soal)
    {
        $soal->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }
}
