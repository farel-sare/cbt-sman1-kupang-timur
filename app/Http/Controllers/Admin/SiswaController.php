<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        // Filter Berdasarkan Kelas (10, 11, 12)
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter Berdasarkan Jurusan (IPA, IPS, dll)
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        // Pencarian Nama / Username / NIS
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('username', 'like', '%'.$request->search.'%');
            });
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.siswa.index', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'username.unique' => 'NIS/Username sudah digunakan oleh siswa lain.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
}
