<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar Modern (Dark Slate) -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-none shadow-2xl z-20">
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            </div>
            <div class="overflow-hidden">
                <h1 class="font-bold text-xs text-white leading-snug tracking-normal font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                <p class="text-[10px] text-indigo-400 font-semibold tracking-wider uppercase mt-0.5">Panel Admin</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-house w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Ujian</div>

            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-database w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Bank Soal
            </a>

            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Jadwal Ujian
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen User</div>

            <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-chalkboard-user w-6 text-center text-indigo-200 mr-2"></i> Data Guru
            </a>

            <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-users w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Data Siswa
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Data Nilai</div>

            <a href="{{ route('admin.rekap-nilai.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-chart-line w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Rekap Nilai
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keamanan Sistem</div>

            <a href="{{ route('admin.monitoring-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-desktop w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Monitoring Ujian
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-red-500/10 hover:text-red-400 rounded-xl text-slate-400 font-bold transition-all text-left group">
                    <i class="fa-solid fa-power-off w-6 text-center group-hover:text-red-400 mr-2 transition-colors"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-sm font-semibold text-slate-500 bg-slate-100/80 px-4 py-2 rounded-full">
                <i class="fa-solid fa-chalkboard-user mr-2 text-indigo-500"></i> Data Guru Pengajar
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ auth()->user()->role ?? 'Administrator' }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=4f46e5&color=fff&font-family=Plus+Jakarta+Sans" alt="Admin" class="h-full w-full object-cover">
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-serif-custom">Manajemen Data Guru</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Kelola akun guru dan mata pelajaran yang diampu.</p>
                    </div>
                    <button onclick="document.getElementById('modalTambahGuru').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 font-semibold flex items-center transition-all">
                        <i class="fa-solid fa-plus mr-2 text-sm"></i> Tambah Guru Baru
                    </button>
                </div>

                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm flex items-center shadow-sm">
                    <i class="fa-solid fa-check mr-3 text-emerald-600 text-lg"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm shadow-sm">
                    <ul class="list-disc list-inside font-semibold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Tabel Data Guru -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 text-center w-16">No</th>
                                    <th class="p-5">Nama Guru</th>
                                    <th class="p-5">NIP</th>
                                    <th class="p-5">Mata Pelajaran Pengampu</th>
                                    <th class="p-5 text-center">Jenis Kelamin</th>
                                    <th class="p-5 text-center w-20">Foto</th>
                                    <th class="p-5 text-center">Status</th>
                                    <th class="p-5 text-right pr-6 w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600 divide-y divide-slate-100">
                                @forelse($gurus as $index => $guru)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <!-- 1. NO -->
                                    <td class="p-5 text-center font-semibold text-slate-400">
                                        {{ $gurus->firstItem() + $index }}
                                    </td>

                                    <!-- 2. NAMA GURU -->
                                    <td class="p-5 font-bold text-slate-800">
                                        {{ $guru->name }}
                                    </td>

                                    <!-- 3. NIP -->
                                    <td class="p-5 font-semibold text-slate-700">
                                        {{ $guru->nip ?? $guru->username ?? '-' }}
                                    </td>

                                    <!-- 4. MATA PELAJARAN PENGAMPU -->
                                    <td class="p-5">
                                        @if($guru->mataPelajaran)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                <i class="fa-solid fa-book-bookmark mr-1.5 text-indigo-500"></i>
                                                {{ $guru->mataPelajaran->nama ?? $guru->mataPelajaran->name }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-400 border border-slate-200">
                                                Belum Ditentukan
                                            </span>
                                        @endif
                                    </td>

                                    <!-- 5. JENIS KELAMIN -->
                                    <td class="p-5 text-center font-bold text-slate-600">
                                        @if(($guru->jenis_kelamin ?? 'L') == 'L')
                                            <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg border border-slate-200">Laki-Laki</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg border border-slate-200">Perempuan</span>
                                        @endif
                                    </td>

                                    <!-- 6. FOTO -->
                                    <td class="p-5 text-center">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 border border-slate-200 overflow-hidden mx-auto flex items-center justify-center">
                                            @if($guru->foto_profil)
                                                <img src="{{ asset('storage/' . $guru->foto_profil) }}" alt="{{ $guru->name }}" class="h-full w-full object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->name) }}&background=4f46e5&color=fff&font-family=Plus+Jakarta+Sans" alt="{{ $guru->name }}" class="h-full w-full object-cover">
                                            @endif
                                        </div>
                                    </td>

                                    <!-- 7. STATUS -->
                                    <td class="p-5 text-center">
                                        @if(($guru->status_akun ?? 'aktif') == 'aktif')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Non-Aktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- 8. AKSI -->
                                    <td class="p-5 text-right pr-6">
                                        <div class="flex justify-end items-center space-x-2">
                                            <!-- Tombol Edit Guru -->
                                            <button onclick="openEditModal({{ json_encode($guru) }})" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white h-9 w-9 rounded-xl inline-flex items-center justify-center transition shadow-sm" title="Edit Data Guru">
                                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                                            </button>

                                            <!-- Tombol Hapus Guru -->
                                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun guru ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white h-9 w-9 rounded-xl inline-flex items-center justify-center transition shadow-sm" title="Hapus Guru">
                                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="p-12 text-center text-slate-400 font-semibold">
                                        Belum ada data guru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($gurus->hasPages())
                    <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                        {{ $gurus->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL TAMBAH GURU -->
    <div id="modalTambahGuru" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl p-8 max-w-lg w-full shadow-2xl border border-slate-100 my-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Tambah Guru Baru</h3>
                <button onclick="document.getElementById('modalTambahGuru').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIP (Login)</label>
                            <input type="text" name="nip" required placeholder="Contoh: 19850115..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap Guru</label>
                            <input type="text" name="name" required placeholder="Nama & Gelar" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Akun</label>
                            <select name="status_akun" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mata Pelajaran Pengampu</label>
                        <select name="mata_pelajaran_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama ?? $mapel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                        <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto Profil (Opsional)</label>
                        <input type="file" name="foto_profil" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('modalTambahGuru').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md">Simpan Guru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT GURU -->
    <div id="modalEditGuru" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl p-8 max-w-lg w-full shadow-2xl border border-slate-100 my-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Edit Data Guru</h3>
                <button onclick="document.getElementById('modalEditGuru').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="formEditGuru" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIP (Login)</label>
                            <input type="text" id="edit_nip" name="nip" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap Guru</label>
                            <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kelamin</label>
                            <select id="edit_jenis_kelamin" name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Akun</label>
                            <select id="edit_status_akun" name="status_akun" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mata Pelajaran Pengampu</label>
                        <select id="edit_mata_pelajaran_id" name="mata_pelajaran_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama ?? $mapel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Baru (Opsional)</label>
                        <input type="password" name="password" minlength="6" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Ganti Foto Profil (Opsional)</label>
                        <input type="file" name="foto_profil" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('modalEditGuru').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(guru) {
            document.getElementById('formEditGuru').action = '/admin/guru/' + guru.id;
            document.getElementById('edit_nip').value = guru.nip ?? guru.username ?? '';
            document.getElementById('edit_name').value = guru.name;
            document.getElementById('edit_jenis_kelamin').value = guru.jenis_kelamin ?? 'L';
            document.getElementById('edit_status_akun').value = guru.status_akun ?? 'aktif';
            document.getElementById('edit_mata_pelajaran_id').value = guru.mata_pelajaran_id ?? '';
            document.getElementById('modalEditGuru').classList.remove('hidden');
        }
    </script>
</body>
</html>
