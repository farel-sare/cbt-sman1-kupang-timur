<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai Ujian - SMAN 1 Kupang Timur</title>

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

            <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-users w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Data Siswa
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Data Nilai</div>

            <a href="{{ route('admin.rekap-nilai.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-chart-line w-6 text-center text-indigo-200 mr-2"></i> Rekap Nilai
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
                <i class="fa-solid fa-chart-line mr-2 text-indigo-500"></i> Rekapitulasi Nilai Ujian Siswa
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
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-serif-custom">Rekap Nilai Siswa</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Filter berdasarkan jadwal ujian, kelas, dan jurusan untuk menampilkan data nilai.</p>
                    </div>

                    @if($selectedJadwal && $hasilUjians->count() > 0)
                    <div class="flex items-center space-x-3">
                        <!-- Tombol Export Excel / CSV -->
                        <a href="{{ route('admin.rekap-nilai.export', ['jadwal_ujian_id' => $selectedJadwalId, 'kelas' => $selectedKelas, 'jurusan' => $selectedJurusan]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-200 font-semibold flex items-center transition">
                            <i class="fa-solid fa-file-excel mr-2 text-sm"></i> Export Excel (.csv)
                        </a>

                        <!-- Tombol Cetak / Print -->
                        <a href="{{ route('admin.rekap-nilai.cetak', ['jadwal_ujian_id' => $selectedJadwalId, 'kelas' => $selectedKelas, 'jurusan' => $selectedJurusan]) }}" target="_blank" class="bg-slate-700 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-slate-200 font-semibold flex items-center transition">
                            <i class="fa-solid fa-print mr-2 text-sm"></i> Cetak / Print
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Form Filter Tiga Kolom: Ujian, Kelas, dan Jurusan -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm mb-8">
                    <form action="{{ route('admin.rekap-nilai.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                        <!-- Filter Jadwal Ujian -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pilih Ujian</label>
                            <select name="jadwal_ujian_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">-- Pilih Jadwal Ujian --</option>
                                @foreach($jadwalUjians as $jadwal)
                                    <option value="{{ $jadwal->id }}" {{ $selectedJadwalId == $jadwal->id ? 'selected' : '' }}>
                                        {{ $jadwal->judul }} ({{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? 'Mapel' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Kelas -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Filter Kelas</label>
                            <select name="kelas" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">Semua Kelas</option>
                                @foreach($listKelas as $kls)
                                    <option value="{{ $kls }}" {{ $selectedKelas == $kls ? 'selected' : '' }}>Kelas {{ $kls }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Jurusan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Filter Jurusan</label>
                            <select name="jurusan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                <option value="">Semua Jurusan</option>
                                @foreach($listJurusan as $jrs)
                                    <option value="{{ $jrs }}" {{ $selectedJurusan == $jrs ? 'selected' : '' }}>{{ $jrs }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="md:col-span-4 flex justify-end gap-2 mt-2">
                            <a href="{{ route('admin.rekap-nilai.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-sm transition">
                                Reset Filter
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-md">
                                <i class="fa-solid fa-filter mr-2"></i> Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Hasil Ujian -->
                @if($selectedJadwal)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                        <div>
                            <h3 class="font-bold text-base text-slate-800">{{ $selectedJadwal->judul }}</h3>
                            <p class="text-xs text-indigo-600 font-semibold mt-0.5">
                                Mapel: {{ $selectedJadwal->mataPelajaran->nama ?? $selectedJadwal->mataPelajaran->name ?? '-' }}
                                @if($selectedKelas) | Kelas: {{ $selectedKelas }} @endif
                                @if($selectedJurusan) | Jurusan: {{ $selectedJurusan }} @endif
                            </p>
                        </div>
                        <span class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg border border-indigo-100 self-start sm:self-auto">
                            Total Tampil: {{ $hasilUjians->count() }} Siswa
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 text-center w-16">No</th>
                                    <th class="p-5">Nama Siswa</th>
                                    <th class="p-5">NISN / Username</th>
                                    <th class="p-5 text-center">Kelas</th>
                                    <th class="p-5 text-center">Jurusan</th>
                                    <th class="p-5 text-center">Benar</th>
                                    <th class="p-5 text-center">Salah</th>
                                    <th class="p-5 text-center">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600 divide-y divide-slate-100">
                                @forelse($hasilUjians as $index => $hasil)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-5 text-center font-semibold text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="p-5 font-bold text-slate-800">{{ $hasil->nama_siswa }}</td>
                                    <td class="p-5 font-semibold text-slate-600">{{ $hasil->nisn }}</td>
                                    <td class="p-5 text-center font-bold text-slate-700">{{ $hasil->kelas ?? '-' }}</td>
                                    <td class="p-5 text-center font-bold text-slate-700">{{ $hasil->jurusan ?? '-' }}</td>
                                    <td class="p-5 text-center font-bold text-emerald-600 bg-emerald-50/50">{{ $hasil->jumlah_benar }}</td>
                                    <td class="p-5 text-center font-bold text-rose-600 bg-rose-50/50">{{ $hasil->jumlah_salah }}</td>
                                    <td class="p-5 text-center font-extrabold text-base">
                                        <span class="inline-block px-3 py-1 rounded-xl {{ $hasil->nilai >= 75 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                            {{ number_format($hasil->nilai, 1) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="p-12 text-center text-slate-400 font-semibold">
                                        Tidak ditemukan data hasil ujian yang sesuai dengan kriteria filter.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/60 shadow-sm text-slate-400">
                    <i class="fa-solid fa-list-check text-4xl mb-3 text-slate-300"></i>
                    <p class="font-bold text-slate-600 text-base">Silakan pilih jadwal ujian terlebih dahulu</p>
                    <p class="text-xs text-slate-400 mt-1">Anda juga dapat menyaring siswa berdasarkan Kelas dan Jurusan spesifik.</p>
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
