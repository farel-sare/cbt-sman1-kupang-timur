<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SMAN 1 Kupang Timur</title>

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

            <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-chalkboard-user w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Data Guru
            </a>

            <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-users w-6 text-center text-indigo-200 mr-2"></i> Data Siswa
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

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="hidden md:flex items-center text-sm font-bold text-slate-500 bg-slate-100/80 px-4 py-2.5 rounded-full">
                <i class="fa-regular fa-calendar-check mr-2 text-indigo-500"></i>
                {{ now()->translatedFormat('l, d F Y') }}
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

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">

                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3.5 rounded-xl text-sm font-bold flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-check mr-2.5 text-lg"></i> {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3.5 rounded-xl text-sm font-bold shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Header Halaman -->
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight font-serif-custom">Manajemen Data Siswa</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Kelola akun siswa berdasarkan Kelas dan Jurusan.</p>
                    </div>
                    <button onclick="document.getElementById('modalTambahSiswa').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 font-bold flex items-center transition-all duration-200">
                        <i class="fa-solid fa-plus mr-2 text-sm"></i> Tambah Siswa Baru
                    </button>
                </div>

                <!-- Filter & Search Bar -->
                <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-200/60 mb-6">
                    <form method="GET" action="{{ route('admin.siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">

                        <!-- Search Box -->
                        <div class="sm:col-span-5 relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIS..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        <!-- Filter Kelas -->
                        <div class="sm:col-span-3">
                            <select name="kelas" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">-- Semua Kelas --</option>
                                <option value="10" {{ request('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                                <option value="11" {{ request('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                                <option value="12" {{ request('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                            </select>
                        </div>

                        <!-- Filter Jurusan -->
                        <div class="sm:col-span-3">
                            <select name="jurusan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">-- Semua Jurusan --</option>
                                <option value="IPA" {{ request('jurusan') == 'IPA' ? 'selected' : '' }}>IPA</option>
                                <option value="IPS" {{ request('jurusan') == 'IPS' ? 'selected' : '' }}>IPS</option>
                                <option value="Bahasa" {{ request('jurusan') == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                                <option value="Umum" {{ request('jurusan') == 'Umum' ? 'selected' : '' }}>Umum / Merdeka</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="sm:col-span-1">
                            <button type="submit" class="w-full h-full bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold flex items-center justify-center transition p-2.5" title="Filter">
                                <i class="fa-solid fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data Siswa -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 pl-6">No</th>
                                    <th class="p-5">Nama Siswa</th>
                                    <th class="p-5">NIS / Username</th>
                                    <th class="p-5 text-center">Kelas</th>
                                    <th class="p-5 text-center">Jurusan</th>
                                    <th class="p-5 text-right pr-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600 divide-y divide-slate-100">
                                @forelse($siswas as $index => $siswa)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-5 pl-6 font-bold text-slate-400">{{ $siswas->firstItem() + $index }}</td>
                                    <td class="p-5 font-bold text-slate-800">{{ $siswa->name }}</td>
                                    <td class="p-5 font-bold text-indigo-600">{{ $siswa->username }}</td>
                                    <td class="p-5 text-center">
                                        <span class="bg-blue-50 text-blue-700 text-xs font-extrabold px-3 py-1 rounded-full border border-blue-200">
                                            Kelas {{ $siswa->kelas ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-emerald-50 text-emerald-700 text-xs font-extrabold px-3 py-1 rounded-full border border-emerald-200">
                                            {{ $siswa->jurusan ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-right pr-6">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="editSiswa('{{ $siswa->id }}', '{{ $siswa->name }}', '{{ $siswa->username }}', '{{ $siswa->kelas }}', '{{ $siswa->jurusan }}')" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white h-9 w-9 rounded-xl flex items-center justify-center transition-colors shadow-sm" title="Edit Siswa">
                                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                                            </button>
                                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white h-9 w-9 rounded-xl flex items-center justify-center transition-colors shadow-sm" title="Hapus Siswa">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-500 font-medium">
                                        Belum ada data siswa ditemukan untuk kriteria ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($siswas->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $siswas->links() }}
                    </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Tambah Siswa -->
    <div id="modalTambahSiswa" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Tambah Siswa Baru</h3>
                <button onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIS / Username</label>
                        <input type="text" name="username" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kelas</label>
                            <select name="kelas" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="10">Kelas 10</option>
                                <option value="11">Kelas 11</option>
                                <option value="12">Kelas 12</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jurusan</label>
                            <select name="jurusan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="Bahasa">Bahasa</option>
                                <option value="Umum">Umum</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl text-sm shadow-md">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div id="modalEditSiswa" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Edit Data Siswa</h3>
                <button onclick="document.getElementById('modalEditSiswa').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form id="formEditSiswa" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIS / Username</label>
                        <input type="text" id="edit_username" name="username" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kelas</label>
                            <select id="edit_kelas" name="kelas" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="10">Kelas 10</option>
                                <option value="11">Kelas 11</option>
                                <option value="12">Kelas 12</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jurusan</label>
                            <select id="edit_jurusan" name="jurusan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="Bahasa">Bahasa</option>
                                <option value="Umum">Umum</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('modalEditSiswa').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl text-sm shadow-md">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editSiswa(id, name, username, kelas, jurusan) {
            document.getElementById('formEditSiswa').action = '/admin/siswa/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_kelas').value = kelas || '10';
            document.getElementById('edit_jurusan').value = jurusan || 'IPA';
            document.getElementById('modalEditSiswa').classList.remove('hidden');
        }
    </script>
</body>
</html>
