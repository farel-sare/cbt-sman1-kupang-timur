<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileSidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js & Chart.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="mobileSidebarOpen"
         x-cloak
         @click="mobileSidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 md:hidden transition-opacity"></div>

    <!-- Sidebar Modern (Desktop & Mobile Drawer) -->
    <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           class="fixed md:static inset-y-0 left-0 w-72 bg-slate-900 text-slate-300 flex flex-col flex-none shadow-2xl z-40 transition-transform duration-300 ease-in-out">

        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="flex items-center">
                <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                    <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                </div>
                <div class="overflow-hidden">
                    <h1 class="font-bold text-xs text-white leading-snug tracking-normal font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                    <p class="text-[10px] text-indigo-400 font-semibold tracking-wider uppercase mt-0.5">Panel Admin</p>
                </div>
            </div>
            <button @click="mobileSidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-house w-6 text-center text-indigo-200 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Ujian</div>

            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
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

            <a href="{{ route('admin.rekap-nilai.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-chart-line w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Rekap Nilai
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keamanan Sistem</div>

            <a href="{{ route('admin.monitoring-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-desktop w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Monitoring Ujian
            </a>
        </nav>

        <!-- Button Logout -->
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
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-4 sm:px-8 shadow-sm z-10 flex-none">
            <div class="flex items-center space-x-3">
                <!-- Hamburger Button untuk Mobile -->
                <button @click="mobileSidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100/80 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full flex items-center">
                    <i class="fa-regular fa-calendar-check mr-2 text-indigo-500"></i>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ auth()->user()->role ?? 'Administrator' }}</p>
                </div>
                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-indigo-100 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=4f46e5&color=fff&font-family=Plus+Jakarta+Sans" alt="Admin" class="h-full w-full object-cover">
                </div>
            </div>
        </header>

        <!-- Main Body Scrollable -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Welcome Banner -->
                <div class="relative bg-gradient-to-r from-indigo-900 via-indigo-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl overflow-hidden">
                    <div class="relative z-10 max-w-2xl">
                        <span class="bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider inline-block mb-3">Selamat Datang Kembali</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-serif-custom">Sistem Ujian Online</h2>
                        <p class="text-indigo-200 text-xs sm:text-sm mt-2 leading-relaxed">
                            Kelola jadwal ujian, bank soal, data pengguna, dan pantau jalannya pelaksanaan ujian SMAN 1 Kupang Timur secara real-time.
                        </p>
                    </div>
                    <!-- Decorative Icon Watermark -->
                    <i class="fa-solid fa-graduation-cap absolute -right-6 -bottom-8 text-indigo-500/10 text-9xl pointer-events-none hidden sm:block"></i>
                </div>

                <!-- 4 METRIC STATISTIC CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <!-- Card 1: Total Siswa -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalSiswa ?? 0) }}</h3>
                            <p class="text-[11px] text-emerald-600 font-bold mt-1 flex items-center">
                                <i class="fa-solid fa-user-check mr-1"></i> Terverifikasi Aktif
                            </p>
                        </div>
                        <div class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>

                    <!-- Card 2: Total Guru -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Guru Pengajar</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalGuru ?? 0) }}</h3>
                            <p class="text-[11px] text-indigo-600 font-bold mt-1 flex items-center">
                                <i class="fa-solid fa-book-open mr-1"></i> Pengampu Mapel
                            </p>
                        </div>
                        <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                    </div>

                    <!-- Card 3: Total Bank Soal -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Bank Soal</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalBankSoal ?? 0) }}</h3>
                            <p class="text-[11px] text-emerald-600 font-bold mt-1 flex items-center">
                                <i class="fa-solid fa-check-double mr-1"></i> Siap Diujikan
                            </p>
                        </div>
                        <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-database"></i>
                        </div>
                    </div>

                    <!-- Card 4: Ujian Hari Ini -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ujian Hari Ini</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ number_format($totalUjianHariIni ?? 0) }}</h3>
                            <p class="text-[11px] text-rose-500 font-bold mt-1 flex items-center">
                                <i class="fa-solid fa-clock mr-1"></i> Sesi Dijadwalkan
                            </p>
                        </div>
                        <div class="h-12 w-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                    </div>
                </div>

                <!-- MIDDLE SECTION: Ujian Berlangsung & Analytics -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- LEFT COLUMN (2 Cols) -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Widget Ujian Sedang Berlangsung -->
                        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                                <div class="flex items-center space-x-3">
                                    <span class="relative flex h-3 w-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    </span>
                                    <h3 class="font-bold text-base text-slate-800">Sesi Ujian Sedang Berlangsung</h3>
                                </div>
                                <a href="{{ route('admin.monitoring-ujian.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 transition">
                                    Monitoring Realtime <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>

                            @if(isset($ujianBerlangsung) && $ujianBerlangsung)
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="space-y-1">
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase border border-emerald-200">AKTIF</span>
                                    <h4 class="font-bold text-slate-800 text-lg">{{ $ujianBerlangsung->judul }}</h4>
                                    <p class="text-xs text-slate-500 font-medium">
                                        Mapel: <strong class="text-slate-700">{{ $ujianBerlangsung->mataPelajaran->nama ?? 'Umum' }}</strong> | Durasi: <strong>{{ $ujianBerlangsung->durasi }} Menit</strong>
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-3 md:pt-0 border-slate-200">
                                    <div class="text-right">
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">Token Ujian</p>
                                        <p class="font-mono font-extrabold text-indigo-600 text-lg tracking-wider">{{ $ujianBerlangsung->token ?? '-' }}</p>
                                    </div>
                                    <a href="{{ route('admin.monitoring-ujian.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md transition">
                                        Pantau Peserta
                                    </a>
                                </div>
                            </div>
                            @else
                            <div class="p-8 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                                <i class="fa-regular fa-calendar-xmark text-3xl text-slate-300 mb-2"></i>
                                <p class="text-sm font-bold text-slate-600">Tidak ada sesi ujian yang berlangsung saat ini</p>
                                <p class="text-xs text-slate-400 mt-0.5">Jadwal ujian aktif dapat dibuka melalui menu Jadwal Ujian.</p>
                            </div>
                            @endif
                        </div>

                        <!-- Grafik Analisis Nilai -->
                        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-base text-slate-800">Rata-Rata Nilai Ujian Per Jurusan</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Perbandingan performa akademis siswa IPA, IPS, dan Bahasa.</p>
                                </div>
                            </div>
                            <div class="h-64 relative">
                                <canvas id="chartNilaiJurusan"></canvas>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN (1 Col) -->
                    <div class="space-y-6">

                        <!-- Pengumuman & Aksi Cepat -->
                        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-6">
                            <h3 class="font-bold text-base text-slate-800 mb-4 flex items-center">
                                <i class="fa-solid fa-bolt text-amber-500 mr-2"></i> Akses Cepat Admin
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('admin.bank-soal.create') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 rounded-2xl border border-slate-200/80 transition text-center group">
                                    <i class="fa-solid fa-plus-circle text-2xl text-indigo-600 group-hover:scale-110 transition-transform mb-2 block"></i>
                                    <span class="text-xs font-bold text-slate-700 block">Buat Soal</span>
                                </a>
                                <a href="{{ route('admin.jadwal-ujian.create') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 rounded-2xl border border-slate-200/80 transition text-center group">
                                    <i class="fa-solid fa-calendar-plus text-2xl text-indigo-600 group-hover:scale-110 transition-transform mb-2 block"></i>
                                    <span class="text-xs font-bold text-slate-700 block">Buat Jadwal</span>
                                </a>
                                <a href="{{ route('admin.siswa.index') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 rounded-2xl border border-slate-200/80 transition text-center group">
                                    <i class="fa-solid fa-user-plus text-2xl text-indigo-600 group-hover:scale-110 transition-transform mb-2 block"></i>
                                    <span class="text-xs font-bold text-slate-700 block">Data Siswa</span>
                                </a>
                                <a href="{{ route('admin.rekap-nilai.index') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 rounded-2xl border border-slate-200/80 transition text-center group">
                                    <i class="fa-solid fa-file-invoice text-2xl text-indigo-600 group-hover:scale-110 transition-transform mb-2 block"></i>
                                    <span class="text-xs font-bold text-slate-700 block">Cetak Rekap</span>
                                </a>
                            </div>
                        </div>

                        <!-- Info Server Status -->
                        <div class="bg-slate-900 text-slate-300 rounded-3xl p-6 shadow-md border border-slate-800">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center">
                                <i class="fa-solid fa-server text-indigo-400 mr-2"></i> Status Sistem CBT
                            </h3>
                            <div class="space-y-3 text-xs">
                                <div class="flex justify-between items-center pb-2 border-b border-slate-800">
                                    <span class="text-slate-400">Database Server</span>
                                    <span class="text-emerald-400 font-bold flex items-center"><i class="fa-solid fa-circle text-[8px] mr-1.5"></i> Terhubung</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-slate-800">
                                    <span class="text-slate-400">Keamanan Anti-Cheat</span>
                                    <span class="text-emerald-400 font-bold flex items-center"><i class="fa-solid fa-shield-halved mr-1"></i> Aktif</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-400">Waktu Server (WITA)</span>
                                    <span class="text-indigo-300 font-mono font-bold">{{ now()->format('H:i') }} WITA</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Script Chart.js -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chartNilaiJurusan').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['MIPA', 'IPS', 'BAHASA', 'UMUM'],
                    datasets: [{
                        label: 'Rata-Rata Nilai Ujian',
                        data: [84.5, 78.2, 81.0, 80.5],
                        backgroundColor: [
                            'rgba(79, 70, 229, 0.85)',
                            'rgba(245, 158, 11, 0.85)',
                            'rgba(16, 185, 129, 0.85)',
                            'rgba(99, 102, 241, 0.85)'
                        ],
                        borderRadius: 12,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: 'rgba(226, 232, 240, 0.6)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
