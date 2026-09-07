<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'guru')
                    ->with('mataPelajaran')
                    ->latest()
                    ->paginate(10);

        $mataPelajarans = MataPelajaran::all();

        return view('admin.guru.index', compact('gurus', 'mataPelajarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'               => 'required|string|max:50|unique:users,nip',
            'name'              => 'required|string|max:255',
            'password'          => 'required|string|min:6',
            'jenis_kelamin'     => 'required|in:L,P',
            'status_akun'       => 'required|in:aktif,nonaktif',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajarans,id',
            'foto_profil'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nip.required'          => 'NIP wajib diisi.',
            'nip.unique'            => 'NIP sudah terdaftar.',
            'name.required'         => 'Nama guru wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'jenis_kelamin.required'=> 'Jenis kelamin wajib dipilih.',
            'status_akun.required'  => 'Status akun wajib dipilih.',
            'foto_profil.image'     => 'Foto profil harus berupa gambar.',
            'foto_profil.max'       => 'Ukuran foto profil maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('foto-guru', 'public');
        }

        User::create([
            'nip'               => $request->nip,
            'username'          => $request->nip,
            'email'             => $request->nip . '@sman1kupangtimur.sch.id', // Dummy email jika kolom database mengharuskan nilai
            'name'              => $request->name,
            'password'          => Hash::make($request->password),
            'role'              => 'guru',
            'jenis_kelamin'     => $request->jenis_kelamin,
            'status_akun'       => $request->status_akun,
            'foto_profil'       => $fotoPath,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $request->validate([
            'nip'               => 'required|string|max:50|unique:users,nip,' . $id,
            'name'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:L,P',
            'status_akun'       => 'required|in:aktif,nonaktif',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajarans,id',
            'foto_profil'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nip.required'          => 'NIP wajib diisi.',
            'nip.unique'            => 'NIP sudah digunakan.',
            'name.required'         => 'Nama guru wajib diisi.',
            'jenis_kelamin.required'=> 'Jenis kelamin wajib dipilih.',
            'status_akun.required'  => 'Status akun wajib dipilih.',
            'foto_profil.image'     => 'Foto profil harus berupa gambar.',
            'foto_profil.max'       => 'Ukuran foto profil maksimal 2MB.',
        ]);

        $data = [
            'nip'               => $request->nip,
            'username'          => $request->nip,
            'email'             => $request->nip . '@sman1kupangtimur.sch.id',
            'name'              => $request->name,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'status_akun'       => $request->status_akun,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            if ($guru->foto_profil && Storage::disk('public')->exists($guru->foto_profil)) {
                Storage::disk('public')->delete($guru->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto-guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        if ($guru->foto_profil && Storage::disk('public')->exists($guru->foto_profil)) {
            Storage::disk('public')->delete($guru->foto_profil);
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}
