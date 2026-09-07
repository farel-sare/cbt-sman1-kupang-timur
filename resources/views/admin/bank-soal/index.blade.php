<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal - SMAN 1 Kupang Timur</title>

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

            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-database w-6 text-center text-indigo-200 mr-2"></i> Bank Soal
            </a>

            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Jadwal Ujian
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen User</div>

            <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-chalkboard-user w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Data Guru
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
                <i class="fa-solid fa-database mr-2 text-indigo-500"></i> Manajemen Bank Soal
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
                <!-- Header Halaman & Tombol Aksi -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight font-serif-custom">Daftar Soal Ujian</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Ringkasan total jumlah soal per mata pelajaran.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="document.getElementById('modalImportSoal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-200 font-semibold flex items-center transition-all duration-200">
                            <i class="fa-solid fa-file-excel mr-2 text-sm"></i> Import Soal
                        </button>
                        <a href="{{ route('admin.bank-soal.create') }}" class="bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 font-semibold flex items-center transition-all duration-200">
                            <i class="fa-solid fa-plus mr-2 text-sm"></i> Tambah Soal Baru
                        </a>
                    </div>
                </div>

                <!-- Alert Sukses -->
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm flex items-center shadow-sm">
                    <i class="fa-solid fa-check mr-3 text-emerald-600 text-lg"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                @endif

                <!-- TAB FILTER KELAS -->
                <div class="mb-6 flex items-center space-x-2 bg-white p-2.5 rounded-2xl border border-slate-200/60 shadow-sm overflow-x-auto">
                    <a href="{{ route('admin.bank-soal.index') }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center space-x-2 {{ !request('kelas') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span>Semua Kelas</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ !request('kelas') ? 'bg-indigo-500 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countSemua }}</span>
                    </a>

                    <a href="{{ route('admin.bank-soal.index', ['kelas' => '10']) }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center space-x-2 {{ request('kelas') == '10' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span>Kelas 10 (X)</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ request('kelas') == '10' ? 'bg-indigo-500 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countKelas10 }}</span>
                    </a>

                    <a href="{{ route('admin.bank-soal.index', ['kelas' => '11']) }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center space-x-2 {{ request('kelas') == '11' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span>Kelas 11 (XI)</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ request('kelas') == '11' ? 'bg-indigo-500 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countKelas11 }}</span>
                    </a>

                    <a href="{{ route('admin.bank-soal.index', ['kelas' => '12']) }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center space-x-2 {{ request('kelas') == '12' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span>Kelas 12 (XII)</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ request('kelas') == '12' ? 'bg-indigo-500 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countKelas12 }}</span>
                    </a>
                </div>

                <!-- Tabel Ringkasan Mata Pelajaran & Jumlah Soal -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 text-center w-16">No</th>
                                    <th class="p-5">Mata Pelajaran</th>
                                    <th class="p-5 text-center">Tingkat Kelas Filter</th>
                                    <th class="p-5 text-center">Total Jumlah Soal</th>
                                    <th class="p-5 text-right pr-6 w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600 divide-y divide-slate-100">
                                @forelse($mataPelajarans as $index => $mapel)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-5 text-center font-semibold text-slate-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="p-5 font-bold text-slate-800">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-9 w-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                                <i class="fa-solid fa-book-bookmark"></i>
                                            </div>
                                            <span>{{ $mapel->nama ?? $mapel->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        @if($kelasAktif)
                                            <span class="bg-amber-100 text-amber-800 font-bold px-3 py-1 rounded-lg text-xs border border-amber-200">
                                                Kelas {{ $kelasAktif }}
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-600 font-bold px-3 py-1 rounded-lg text-xs border border-slate-200">
                                                Semua Kelas
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-emerald-100 text-emerald-800 font-extrabold px-3.5 py-1.5 rounded-full text-xs border border-emerald-200">
                                            {{ $mapel->soals_count }} Soal
                                        </span>
                                    </td>
                                    <td class="p-5 text-right pr-6">
                                        <a href="{{ route('admin.bank-soal.detail', ['mata_pelajaran_id' => $mapel->id, 'kelas' => $kelasAktif]) }}"
                                           class="bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-600 px-4 py-2 rounded-xl text-xs font-bold transition inline-flex items-center space-x-1.5 shadow-sm">
                                            <i class="fa-solid fa-list-check"></i>
                                            <span>Detail Soal</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400">
                                        Belum ada data mata pelajaran.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Import Soal CSV -->
    <div id="modalImportSoal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Import Soal dari CSV</h3>
                <button onclick="document.getElementById('modalImportSoal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.bank-soal.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tingkat Kelas</label>
                        <select name="kelas" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="10">Kelas 10 (X)</option>
                            <option value="11">Kelas 11 (XI)</option>
                            <option value="12">Kelas 12 (XII)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajarans ?? [] as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama ?? $mapel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">File CSV</label>
                        <input type="file" name="file" accept=".csv" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-700">Belum punya formatnya?</p>
                            <p class="text-[11px] text-slate-500">Unduh contoh susunan kolom CSV.</p>
                        </div>
                        <a href="{{ route('admin.bank-soal.download-template') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-200 flex items-center">
                            <i class="fa-solid fa-download mr-1.5"></i> Template
                        </a>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('modalImportSoal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow-md">Proses Import</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
