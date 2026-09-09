<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 h-screen overflow-hidden">

    <div x-data="dashboardApp()" x-cloak class="flex h-screen overflow-hidden relative">

        <!-- Overlay Mobile Sidebar -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-20 md:hidden transition-opacity">
        </div>

        <!-- Sidebar Modern Guru -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed md:static inset-y-0 left-0 w-72 bg-slate-900 text-slate-300 flex flex-col flex-none shadow-2xl z-30 transition-transform duration-300 ease-in-out">
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/50">
                <div class="flex items-center">
                    <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                        <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                    </div>
                    <div class="overflow-hidden">
                        <h1 class="font-bold text-xs text-white leading-snug font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                        <p class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase mt-0.5">PANEL GURU</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
                <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-900/30 transition-all">
                    <i class="fa-solid fa-house w-6 text-center text-blue-200 mr-2"></i> Dashboard
                </a>

                <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">KELOLA EVALUASI</div>

                <a href="{{ route('guru.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                    <i class="fa-solid fa-database w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Bank Soal Saya
                </a>

                <a href="{{ route('guru.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                    <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Jadwal Ujian
                </a>

                <a href="{{ route('guru.monitoring.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                    <i class="fa-solid fa-desktop w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Monitoring Realtime
                </a>

                <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">LAPORAN & NILAI</div>

                <a href="{{ route('guru.rekap-nilai.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                    <i class="fa-solid fa-chart-line w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Rekap Nilai Siswa
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
            <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-8 shadow-sm z-10 flex-none">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-slate-600 p-2 rounded-lg border border-slate-200 hover:bg-slate-50">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div class="text-xs font-bold text-blue-700 bg-blue-50 px-4 py-2 rounded-full flex items-center border border-blue-100">
                        <i class="fa-regular fa-calendar mr-2 text-blue-600"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Guru Pengampu' }}</p>
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">
                            {{ auth()->user()->mataPelajaran->nama ?? auth()->user()->mataPelajaran->name ?? 'GURU PENGAMPU' }}
                        </p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Guru" class="h-full w-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guru') }}&background=2563eb&color=fff&font-family=Plus+Jakarta+Sans" alt="Guru" class="h-full w-full object-cover">
                        @endif
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- Toast Notification -->
                    <div x-show="toastMessage" x-cloak class="fixed bottom-5 right-5 z-50 bg-slate-900 text-white px-4 py-3 rounded-xl shadow-xl flex items-center space-x-3 transition-all">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span class="text-xs font-semibold" x-text="toastMessage"></span>
                    </div>

                    <!-- Welcome Banner -->
                    <div class="relative bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/10 overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <span class="bg-white/20 text-white text-[10px] font-extrabold uppercase px-3 py-1 rounded-full border border-white/30 tracking-wider backdrop-blur-sm">Selamat Datang Kembali</span>
                            <h2 class="text-3xl font-bold font-serif-custom mt-2">Halo, {{ auth()->user()->name }}!</h2>
                            <p class="text-blue-100 text-xs sm:text-sm mt-1 max-w-2xl font-medium">
                                Kelola bank soal, atur jadwal ujian CBT, dan pantau hasil rekapitulasi nilai siswa secara langsung dari portal evaluasi Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Widget Akses Cepat -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="{{ route('guru.bank-soal.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-400 transition-all flex items-center space-x-4 group">
                            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Aksi Cepat</p>
                                <p class="text-sm font-bold text-slate-800">Buat Soal Baru</p>
                            </div>
                        </a>

                        <a href="{{ route('guru.jadwal-ujian.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-400 transition-all flex items-center space-x-4 group">
                            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-calendar-plus"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Aksi Cepat</p>
                                <p class="text-sm font-bold text-slate-800">Buat Jadwal Ujian</p>
                            </div>
                        </a>

                        <a href="{{ route('guru.rekap-nilai.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-400 transition-all flex items-center space-x-4 group">
                            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-all">
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
                        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center space-x-5">
                            <div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl border border-blue-100">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Soal Saya</p>
                                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalSoal ?? $totalBankSoal ?? 0 }}</h3>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center space-x-5">
                            <div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl border border-blue-100">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jadwal Ujian</p>
                                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalJadwal ?? count($jadwal_ujians ?? []) }}</h3>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center space-x-5">
                            <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl border border-emerald-100">
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
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-lg text-slate-800">Jadwal Ujian Terbaru</h3>
                                <p class="text-xs text-slate-400">Daftar sesi ujian yang Anda buat dan kelola.</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" x-model="searchQuery" placeholder="Cari nama/mapel..." class="pl-8 pr-4 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 w-40 sm:w-56 transition-all">
                                </div>
                                <a href="{{ route('guru.jadwal-ujian.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl transition whitespace-nowrap">
                                    Kelola Semua <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
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
                                    <template x-for="jadwal in filteredJadwal" :key="jadwal.id">
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="p-4 font-bold text-slate-800" x-text="jadwal.nama_ujian"></td>
                                            <td class="p-4" x-text="jadwal.mapel"></td>
                                            <td class="p-4 text-center">
                                                <span class="bg-slate-100 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-200" x-text="jadwal.kelas"></span>
                                            </td>
                                            <td class="p-4 text-xs text-slate-500" x-text="jadwal.created_at"></td>
                                            <td class="p-4 text-center">
                                                <button @click="copyToken(jadwal.token)"
                                                        title="Klik untuk menyalin token"
                                                        class="font-mono font-extrabold text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg border border-blue-100 transition inline-flex items-center space-x-1 group">
                                                    <span x-text="jadwal.token"></span>
                                                    <i class="fa-regular fa-copy text-[10px] text-blue-400 group-hover:text-blue-600 ml-1"></i>
                                                </button>
                                            </td>
                                            <td class="p-4 text-center">
                                                <template x-if="jadwal.is_active">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Siap Berjalan
                                                    </span>
                                                </template>
                                                <template x-if="!jadwal.is_active">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                        Tutup
                                                    </span>
                                                </template>
                                            </td>
                                            <td class="p-4 text-right">
                                                <a href="{{ route('guru.monitoring.index') }}" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg transition border border-blue-100">
                                                    Pantau
                                                </a>
                                            </td>
                                        </tr>
                                    </template>

                                    <template x-if="filteredJadwal.length === 0">
                                        <tr>
                                            <td colspan="7" class="p-8 text-center text-slate-400 font-semibold">
                                                Tidak ada jadwal ujian yang ditemukan.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>

    </div>

   <!-- Passing Data Blade ke Window Object -->
    @php
        $formattedJadwal = ($jadwal_ujians ?? collect())->map(function($j) {
            return [
                'id'          => $j->id ?? rand(1, 1000),
                'nama_ujian'  => $j->nama_ujian ?? $j->judul ?? 'Ujian CBT',
                'mapel'       => optional($j->mataPelajaran)->nama ?? optional($j->mataPelajaran)->name ?? '-',
                'kelas'       => $j->kelas ?? 'Semua Kelas',
                'created_at'  => isset($j->created_at) ? \Carbon\Carbon::parse($j->created_at)->format('d M Y, H:i') : '-',
                'token'       => $j->token ?? '-',
                'is_active'   => in_array((string)($j->status ?? ''), ['1', 'aktif', 'buka']),
            ];
        });
    @endphp

    <script>
        window.jadwalData = @json($formattedJadwal);

        function dashboardApp() {
            return {
                sidebarOpen: false,
                searchQuery: '',
                toastMessage: '',
                jadwalList: window.jadwalData || [],
                get filteredJadwal() {
                    if (!this.searchQuery) return this.jadwalList;
                    const query = this.searchQuery.toLowerCase();
                    return this.jadwalList.filter(item =>
                        (item.nama_ujian && item.nama_ujian.toLowerCase().includes(query)) ||
                        (item.mapel && item.mapel.toLowerCase().includes(query)) ||
                        (item.kelas && item.kelas.toLowerCase().includes(query))
                    );
                },
                copyToken(token) {
                    if (!token || token === '-') return;
                    navigator.clipboard.writeText(token);
                    this.showToast(`Token '${token}' berhasil disalin!`);
                },
                showToast(msg) {
                    this.toastMessage = msg;
                    setTimeout(() => {
                        this.toastMessage = '';
                    }, 3000);
                }
            }
        }
    </script>
</body>
</html>
