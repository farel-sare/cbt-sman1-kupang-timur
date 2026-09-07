<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SMAN 1 Kupang Timur</title>

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

    <!-- Sidebar Modern Guru -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-none shadow-2xl z-20">
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            </div>
            <div class="overflow-hidden">
                <h1 class="font-bold text-xs text-white leading-snug font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                <p class="text-[10px] text-emerald-400 font-semibold tracking-wider uppercase mt-0.5">PANEL GURU</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 bg-emerald-600 rounded-xl text-white font-semibold shadow-lg shadow-emerald-900/20 transition-all">
                <i class="fa-solid fa-house w-6 text-center text-emerald-200 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">KELOLA EVALUASI</div>

            <a href="{{ route('guru.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-database w-6 text-center text-slate-500 group-hover:text-emerald-400 mr-2"></i> Bank Soal Saya
            </a>

            <a href="#" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-emerald-400 mr-2"></i> Jadwal Ujian
            </a>

            <!-- MENU MONITORING UJIAN -->
            <a href="#" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-desktop w-6 text-center text-slate-500 group-hover:text-emerald-400 mr-2"></i> Monitoring Realtime
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">LAPORAN & NILAI</div>

            <a href="#" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-chart-line w-6 text-center text-slate-500 group-hover:text-emerald-400 mr-2"></i> Rekap Nilai Siswa
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
            <div class="text-xs font-bold text-slate-600 bg-slate-100/80 px-4 py-2 rounded-full flex items-center">
                <i class="fa-regular fa-calendar mr-2 text-emerald-600"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Guru Pengampu' }}</p>
                    <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider">
                        {{ auth()->user()->mataPelajaran->nama ?? auth()->user()->mataPelajaran->name ?? 'GURU PENGAMPU' }}
                    </p>
                </div>
                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                    @if(auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Guru" class="h-full w-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guru') }}&background=059669&color=fff&font-family=Plus+Jakarta+Sans" alt="Guru" class="h-full w-full object-cover">
                    @endif
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Welcome Banner -->
                <div class="relative bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 rounded-3xl p-8 text-white shadow-xl overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <span class="bg-emerald-600/60 text-emerald-100 text-[10px] font-extrabold uppercase px-3 py-1 rounded-full border border-emerald-500/40 tracking-wider">Selamat Datang Kembali</span>
                        <h2 class="text-3xl font-bold font-serif-custom mt-2">Halo, {{ auth()->user()->name }}!</h2>
                        <p class="text-emerald-100/80 text-xs sm:text-sm mt-1 max-w-2xl font-medium">
                            Kelola bank soal, atur jadwal ujian CBT, dan pantau hasil rekapitulasi nilai siswa secara langsung dari portal evaluasi Anda.
                        </p>
                    </div>
                </div>

                <!-- WIDGET Akses Cepat (Quick Actions) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('guru.bank-soal.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex items-center space-x-4 group">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Aksi Cepat</p>
                            <p class="text-sm font-bold text-slate-800">Buat Soal Baru</p>
                        </div>
                    </a>

                    <a href="#" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all flex items-center space-x-4 group">
                        <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Aksi Cepat</p>
                            <p class="text-sm font-bold text-slate-800">Buat Jadwal Ujian</p>
                        </div>
                    </a>

                    <a href="#" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-amber-300 transition-all flex items-center space-x-4 group">
                        <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl group-hover:bg-amber-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Aksi Cepat</p>
                            <p class="text-sm font-bold text-slate-800">Lihat Rekap Nilai</p>
                        </div>
                    </a>
                </div>

                <!-- Cards Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center space-x-5">
                        <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Soal Saya</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalSoal ?? $totalBankSoal ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center space-x-5">
                        <div class="h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jadwal Ujian</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalJadwal ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center space-x-5">
                        <div class="h-14 w-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-server"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Server</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                                <span class="text-sm font-bold text-emerald-600">Online / Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Jadwal Ujian Terbaru -->
                <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800">Jadwal Ujian Terbaru</h3>
                            <p class="text-xs text-slate-400">Daftar sesi ujian yang Anda buat dan kelola.</p>
                        </div>
                        <a href="#" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-4 py-2 rounded-xl transition">
                            Kelola Semua Jadwal <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-wider font-extrabold border-b border-slate-200/60">
                                <tr>
                                    <th class="p-4">Nama / Judul Ujian</th>
                                    <th class="p-4">Mata Pelajaran</th>
                                    <th class="p-4 text-center">Kelas Target</th>
                                    <th class="p-4">Waktu Dibuat</th>
                                    <th class="p-4 text-center">Token</th>
                                    <th class="p-4 text-center">Status</th>
                                    <th class="p-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                                @forelse($jadwal_ujians ?? [] as $jadwal)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="p-4 font-bold text-slate-800">
                                        {{ $jadwal->nama_ujian ?? 'Ujian CBT' }}
                                    </td>
                                    <td class="p-4">
                                        {{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-' }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-slate-100 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-200">
                                            {{ $jadwal->kelas ?? 'Semua Kelas' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-xs text-slate-500">
                                        {{ $jadwal->created_at ? $jadwal->created_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="font-mono font-extrabold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                                            {{ $jadwal->token ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if(in_array(($jadwal->status ?? ''), ['1', 1, 'aktif', 'buka']))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                Siap Berjalan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                Tutup
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="#" class="text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white px-3 py-1.5 rounded-lg transition">
                                            Pantau
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400 font-semibold">
                                        Belum ada jadwal ujian yang dibuat.
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

</body>
</html>
