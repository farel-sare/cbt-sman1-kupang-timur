<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileSidebarOpen: false, showModalWaktu: false, modalPesertaId: null, inputMenit: 10 }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Monitoring & Proctoring - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
        [x-cloak] { display: none !important; }

        /* Status Glow Dots */
        .status-dot {
            height: 9px;
            width: 9px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-online { background-color: #10b981; box-shadow: 0 0 8px #10b981; }
        .dot-warning { background-color: #f59e0b; box-shadow: 0 0 8px #f59e0b; }
        .dot-offline { background-color: #f43f5e; box-shadow: 0 0 8px #f43f5e; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="mobileSidebarOpen"
         x-cloak
         @click="mobileSidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 md:hidden transition-opacity"></div>

    <!-- Sidebar Modern (Dark Slate) -->
    <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           class="fixed md:static inset-y-0 left-0 w-72 bg-slate-900 text-slate-300 flex flex-col flex-none shadow-2xl z-40 transition-transform duration-300 ease-in-out">

        <!-- Logo Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="flex items-center">
                <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                    <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                </div>
                <div class="overflow-hidden">
                    <h1 class="font-bold text-xs text-white leading-snug font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                    <p class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase mt-0.5">Panel Admin</p>
                </div>
            </div>
            <button @click="mobileSidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-house w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Ujian</div>

            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-database w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Bank Soal
            </a>

            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Jadwal Ujian
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen User</div>

            <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-chalkboard-user w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Data Guru
            </a>

            <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-users w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Data Siswa
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Data Nilai</div>

            <a href="{{ route('admin.rekap-nilai.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-chart-line w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Rekap Nilai
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Keamanan Sistem</div>

            <a href="{{ route('admin.monitoring-ujian.index') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-900/20 transition-all">
                <i class="fa-solid fa-desktop w-6 text-center text-blue-200 mr-2"></i> Monitoring Ujian
            </a>
        </nav>

        <!-- Logout Button -->
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

        <!-- Header Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-4 sm:px-8 shadow-sm z-10 flex-none">
            <div class="flex items-center space-x-3">
                <button @click="mobileSidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="text-xs sm:text-sm font-semibold text-slate-600 bg-slate-100 px-3.5 py-2 rounded-full flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span> Live Proctoring & Akses Siswa
                </div>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ auth()->user()->role ?? 'Admin' }}</p>
                </div>
                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2563eb&color=fff&font-family=Plus+Jakarta+Sans" alt="Admin" class="h-full w-full object-cover">
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Title & Controls -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 font-serif-custom flex items-center">
                            <i class="fa-solid fa-desktop text-blue-600 mr-3 text-xl"></i> Live Monitoring Ujian & Proctoring
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">Pengawasan status pengerjaan siswa, waktu real-time, dan manajemen gangguan ujian.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center bg-white border border-slate-200 text-slate-600 px-3 py-2 rounded-xl text-xs font-semibold shadow-sm">
                            <i class="fa-solid fa-rotate fa-spin text-emerald-500 mr-2"></i> Auto Refresh (10s)
                        </span>
                        <button onclick="loadDataMonitoring()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl text-xs sm:text-sm shadow-md shadow-blue-200 transition active:scale-95 flex items-center">
                            <i class="fa-solid fa-arrows-rotate mr-2"></i> Refresh Manual
                        </button>
                    </div>
                </div>

                <!-- 4 Stats Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

                    <!-- Card 1: Sedang Ujian -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm border-l-4 border-l-emerald-500 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Sedang Ujian (Online)</p>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1" id="stat-online">0</h3>
                        </div>
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-circle-play"></i>
                        </div>
                    </div>

                    <!-- Card 2: Terputus / Ragu-ragu -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm border-l-4 border-l-amber-500 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Terputus</p>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-amber-500 mt-1" id="stat-warning">0</h3>
                        </div>
                        <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>

                    <!-- Card 3: Telah Selesai -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm border-l-4 border-l-blue-500 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Telah Selesai</p>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1" id="stat-selesai">0</h3>
                        </div>
                        <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>

                    <!-- Card 4: Terkunci / Pelanggaran -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm border-l-4 border-l-rose-500 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Sesi Terkunci / Pelanggaran</p>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-rose-600 mt-1" id="stat-blocked">0</h3>
                        </div>
                        <div class="h-12 w-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-user-lock"></i>
                        </div>
                    </div>

                </div>

                <!-- Main Monitoring Table Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">

                    <!-- Table Header & Filter Dropdown -->
                    <div class="p-5 sm:p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-users-viewfinder text-blue-600 text-lg"></i>
                            <h3 class="font-bold text-slate-800 text-base">Daftar Aktivitas Siswa</h3>
                        </div>

                        <!-- Filter Jadwal Ujian -->
                        <div class="w-full sm:w-72">
                            <select id="filterJadwal" onchange="loadDataMonitoring()" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm">
                                <option value="">-- Semua Ujian Aktif --</option>
                                @foreach(($jadwalAktif ?? $jadwalUjians ?? []) as $j)
                                    <option value="{{ $j->id }}">
                                        {{ $j->nama_ujian ?? $j->judul }} ({{ $j->bankSoal->mataPelajaran->nama_mapel ?? $j->mataPelajaran->nama ?? $j->mataPelajaran->name ?? 'Mapel' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Table Responsive Wrapper -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse" id="tableMonitoring">
                            <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-4 sm:p-5">Siswa / NISN</th>
                                    <th class="p-4 sm:p-5">kelas</th>
                                    <th class="p-4 sm:p-5">Mata Pelajaran</th>
                                    <th class="p-4 sm:p-5">Progres Soal</th>
                                    <th class="p-4 sm:p-5">Sisa Waktu</th>
                                    <th class="p-4 sm:p-5">Status Koneksi</th>
                                    <th class="p-4 sm:p-5 text-center">Aksi Proctoring</th>
                                </tr>
                            </thead>
                            <tbody id="monitoringContainer" class="text-slate-600 divide-y divide-slate-100 font-medium">
                                <!-- Data diisi oleh AJAX secara berkala -->
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- MODAL TAMBAH WAKTU SISWA (Alpine.js Modal) -->
    <div x-show="showModalWaktu"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay Backdrop -->
            <div x-show="showModalWaktu"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showModalWaktu = false"
                 class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div x-show="showModalWaktu"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">

                <div class="p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fa-solid fa-hourglass-plus text-blue-600 mr-2.5"></i> Tambah Waktu Pengerjaan
                        </h3>
                        <button @click="showModalWaktu = false" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form @submit.prevent="submitTambahWaktu">
                        <div class="py-4 space-y-4">
                            <p class="text-xs text-slate-500 font-medium leading-relaxed">
                                Berikan tambahan waktu bagi siswa yang mengalami kendala teknis (laptop restart, mati listrik, atau kendala jaringan).
                            </p>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Durasi Tambahan (Menit)</label>
                                <input type="number" x-model="inputMenit" min="1" max="120" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalWaktu = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-200 transition">
                                <i class="fa-solid fa-check mr-1.5"></i> Simpan & Tambah Waktu
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts JQuery & SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function() {
            loadDataMonitoring();
            // Polling otomatis setiap 10 detik
            setInterval(loadDataMonitoring, 10000);
        });

        function loadDataMonitoring() {
            const jadwalId = $('#filterJadwal').val();

            $.ajax({
                url: "{{ route('admin.monitoring.data') }}",
                type: "GET",
                data: { jadwal_id: jadwalId },
                success: function(res) {
                    if (res.status) {
                        renderTable(res.data);
                        renderStats(res.summary);
                    }
                },
                error: function() {
                    console.error('Gagal memperbarui data monitoring.');
                }
            });
        }

        function renderStats(s) {
            $('#stat-online').text(s.online || 0);
            $('#stat-warning').text(s.warning || 0);
            $('#stat-selesai').text(s.selesai || 0);
            $('#stat-blocked').text(s.blocked || 0);
        }

        function renderTable(data) {
            let html = '';
            if (!data || data.length === 0) {
                html = `<tr><td colspan="7" class="text-center py-12 text-slate-400 font-medium">Belum ada aktivitas pengerjaan siswa.</td></tr>`;
            } else {
                data.forEach(item => {
                    let statusBadge = '';
                    if (item.status === 'selesai') {
                        statusBadge = `<span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full border border-slate-200"><i class="fa-solid fa-check-double mr-1.5 text-blue-500"></i> Selesai</span>`;
                    } else if (item.is_blocked) {
                        statusBadge = `<span class="inline-flex items-center px-3 py-1 bg-rose-50 text-rose-600 text-xs font-bold rounded-full border border-rose-200"><span class="status-dot dot-offline mr-1.5"></span> Terkunci</span>`;
                    } else if (item.is_online) {
                        statusBadge = `<span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full border border-emerald-200"><span class="status-dot dot-online mr-1.5"></span> Online</span>`;
                    } else {
                        statusBadge = `<span class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-full border border-amber-200"><span class="status-dot dot-warning mr-1.5"></span> Terputus</span>`;
                    }

                    let persenSoal = Math.round((item.soal_terjawab / item.total_soal) * 100) || 0;

                    html += `
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 sm:p-5">
                            <div class="font-bold text-slate-800">${item.siswa_nama}</div>
                            <div class="text-xs text-slate-400 font-semibold mt-0.5">NISN: ${item.siswa_nisn}</div>
                        </td>
                        <td class="p-4 sm:p-5">
                            <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg border border-slate-200">${item.rombel}</span>
                        </td>
                        <td class="p-4 sm:p-5 font-semibold text-slate-700">${item.mapel}</td>
                        <td class="p-4 sm:p-5 min-w-[160px]">
                            <div class="flex justify-between text-xs font-bold mb-1">
                                <span class="text-slate-600">${item.soal_terjawab}/${item.total_soal} Soal</span>
                                <span class="text-blue-600">${persenSoal}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/60">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: ${persenSoal}%"></div>
                            </div>
                        </td>
                        <td class="p-4 sm:p-5 font-bold ${item.sisa_menit < 5 ? 'text-rose-600 animate-pulse' : 'text-blue-600'}">
                            <i class="fa-regular fa-clock mr-1"></i>${item.sisa_menit} Menit
                        </td>
                        <td class="p-4 sm:p-5">${statusBadge}</td>
                        <td class="p-4 sm:p-5 text-center">
                            <div class="inline-flex rounded-xl shadow-sm space-x-1">
                                <button onclick="bukaModalWaktu(${item.id})" class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-lg border border-blue-200 text-xs font-bold transition" title="Tambah Waktu">
                                    <i class="fa-solid fa-hourglass-plus"></i>
                                </button>
                                <button onclick="resetSesiLogin(${item.user_id})" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white rounded-lg border border-amber-200 text-xs font-bold transition" title="Reset Login / Pindah HP">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                                <button onclick="paksaSelesai(${item.id})" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white rounded-lg border border-rose-200 text-xs font-bold transition" title="Hentikan / Paksa Selesai">
                                    <i class="fa-solid fa-power-off"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                });
            }
            $('#monitoringContainer').html(html);
        }

        // ACTION: Reset Sesi
        function resetSesiLogin(userId) {
            Swal.fire({
                title: 'Reset Sesi Login?',
                text: "Gunakan ini jika siswa berpindah perangkat atau perangkat terkunci/restart.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f59e0b',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/user/reset-session/${userId}`, { _token: csrfToken }, function(res) {
                        if(res.status) {
                            Swal.fire({ title: 'Berhasil', text: 'Sesi siswa berhasil di-reset.', icon: 'success', customClass: { popup: 'rounded-3xl' } });
                            loadDataMonitoring();
                        }
                    });
                }
            });
        }

        // ACTION: Paksa Selesai
        function paksaSelesai(pesertaId) {
            Swal.fire({
                title: 'Hentikan Ujian Siswa?',
                text: "Jawaban siswa yang tersimpan akan langsung difinalisasi.",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Paksa Selesai',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e11d48',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/monitoring/force-finish/${pesertaId}`, { _token: csrfToken }, function(res) {
                        if(res.status) {
                            Swal.fire({ title: 'Selesai!', text: 'Ujian siswa berhasil difinalisasi.', icon: 'success', customClass: { popup: 'rounded-3xl' } });
                            loadDataMonitoring();
                        }
                    });
                }
            });
        }

        // ACTION: Buka Modal Tambah Waktu
        function bukaModalWaktu(pesertaId) {
            const rootEl = document.querySelector('[x-data]');
            if (rootEl && rootEl._x_dataStack) {
                rootEl._x_dataStack[0].modalPesertaId = pesertaId;
                rootEl._x_dataStack[0].showModalWaktu = true;
            }
        }

        // ACTION: Submit Tambah Waktu
        function submitTambahWaktu() {
            const rootEl = document.querySelector('[x-data]');
            const dataStack = rootEl._x_dataStack[0];
            const pesertaId = dataStack.modalPesertaId;
            const menit = dataStack.inputMenit;

            $.post(`/admin/monitoring/tambah-waktu/${pesertaId}`, { _token: csrfToken, menit: menit }, function(res) {
                if (res.status) {
                    dataStack.showModalWaktu = false;
                    Swal.fire({ title: 'Waktu Ditambahkan!', text: `Waktu pengerjaan bertambah ${menit} menit.`, icon: 'success', customClass: { popup: 'rounded-3xl' } });
                    loadDataMonitoring();
                }
            });
        }
    </script>

</body>
</html>
