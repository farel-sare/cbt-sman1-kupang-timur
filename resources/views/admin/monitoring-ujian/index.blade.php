<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="monitoringApp()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Monitoring & Proctoring - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar Admin -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-none shadow-2xl z-20">
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            </div>
            <div class="overflow-hidden">
                <h1 class="font-bold text-xs text-white leading-snug font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                <p class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase mt-0.5">PANEL ADMIN</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-house w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Dashboard
            </a>

            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-database w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Bank Soal
            </a>

            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Jadwal Ujian
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">MANAJEMEN USER</div>

            <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-user-tie w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Data Guru
            </a>

            <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-users w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Data Siswa
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">KEAMANAN SISTEM</div>

            <a href="{{ route('admin.monitoring-ujian.index') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-900/30 transition-all">
                <i class="fa-solid fa-desktop w-6 text-center text-blue-200 mr-2"></i> Monitoring Ujian
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-red-500/10 hover:text-red-400 rounded-xl text-slate-400 font-bold transition-all text-left group">
                    <i class="fa-solid fa-power-off w-6 text-center group-hover:text-red-400 mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-xs font-bold text-emerald-700 bg-emerald-50 px-4 py-2 rounded-full flex items-center border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-ping"></span> Live Proctoring & Akses Siswa
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">ADMINISTRATOR</p>
                </div>
                <div class="h-9 w-9 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs">
                    AU
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Title & Controls -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-serif-custom flex items-center">
                            <i class="fa-solid fa-desktop mr-3 text-blue-600"></i> Live Monitoring Ujian & Proctoring
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">Pengawasan status pengerjaan siswa, pelanggaran real-time, dan manajemen akses ujian.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs font-bold text-slate-500 bg-white border border-slate-200 px-3 py-2 rounded-xl shadow-sm flex items-center">
                            <i class="fa-solid fa-arrows-rotate mr-2 text-emerald-500" :class="loading ? 'animate-spin' : ''"></i>
                            Auto Refresh (5s)
                        </span>
                        <button @click="fetchData()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md transition flex items-center">
                            <i class="fa-solid fa-rotate mr-1.5"></i> Refresh Manual
                        </button>
                    </div>
                </div>

                <!-- Toast Notification -->
                <div x-show="toast.show" x-cloak class="p-4 rounded-2xl text-xs font-bold shadow-lg transition-all flex items-center" :class="toast.type === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200'">
                    <i class="fa-solid mr-2 text-sm" :class="toast.type === 'success' ? 'fa-circle-check text-emerald-600' : 'fa-circle-xmark text-rose-600'"></i>
                    <span x-text="toast.message"></span>
                </div>

                <!-- 4 Ringkasan Statistik Real-Time -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between border-l-4 border-l-emerald-500">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Sedang Ujian (Online)</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1" x-text="summary.online">0</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between border-l-4 border-l-amber-500">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Belum Mulai / Warning</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1" x-text="summary.warning">0</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between border-l-4 border-l-rose-500">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Sesi Terkunci / Blocked</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1" x-text="summary.blocked">0</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-user-lock"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between border-l-4 border-l-blue-500">
                        <div>
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Telah Selesai</p>
                            <h3 class="text-2xl font-extrabold text-slate-800 mt-1" x-text="summary.selesai">0</h3>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Tabel Aktivitas Siswa -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-100 gap-4 mb-4">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-users-viewfinder text-blue-600"></i>
                            <h3 class="font-bold text-slate-800 text-sm">Daftar Aktivitas Siswa</h3>
                        </div>

                        <!-- Dropdown Filter Semua Ujian Aktif -->
                        <div class="flex items-center space-x-3 w-full sm:w-auto">
                            <select x-model="selectedJadwalId" @change="fetchData()" class="w-full sm:w-80 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:border-blue-500 shadow-sm">
                                <option value="">-- Semua Ujian Aktif --</option>
                                @foreach($jadwalAktif as $jadwal)
                                    <option value="{{ $jadwal->id }}">
                                        {{ $jadwal->judul ?? $jadwal->nama_ujian ?? 'UAS' }} - {{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-' }} (Kelas {{ $jadwal->kelas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="bg-slate-50 text-slate-400 uppercase tracking-wider font-extrabold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-4">Siswa / NISN</th>
                                    <th class="p-4">Kelas</th>
                                    <th class="p-4">Mata Pelajaran</th>
                                    <th class="p-4 text-center">Progres Soal</th>
                                    <th class="p-4 text-center">Pelanggaran</th>
                                    <th class="p-4 text-center">Status Ujian</th>
                                    <th class="p-4 text-right">Aksi Proctoring</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                                <template x-for="item in siswaList" :key="item.id">
                                    <tr class="hover:bg-slate-50/70 transition-colors">
                                        <td class="p-4 font-bold text-slate-800">
                                            <span x-text="item.siswa_nama"></span>
                                            <span class="block text-[11px] font-normal text-slate-400 mt-0.5" x-text="'NISN: ' + (item.siswa_nisn || '-')"></span>
                                        </td>
                                        <td class="p-4 font-bold text-slate-700" x-text="item.rombel"></td>
                                        <td class="p-4" x-text="item.mapel"></td>
                                        <td class="p-4 text-center font-bold text-slate-800" x-text="item.soal_terjawab + ' / ' + item.total_soal"></td>

                                        <!-- Indikator Jumlah Pelanggaran -->
                                        <td class="p-4 text-center">
                                            <template x-if="item.jumlah_pelanggaran > 0">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold bg-rose-50 text-rose-600 border border-rose-200">
                                                    <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>
                                                    <span x-text="item.jumlah_pelanggaran + '/3'"></span>
                                                </span>
                                            </template>
                                            <template x-if="!item.jumlah_pelanggaran || item.jumlah_pelanggaran == 0">
                                                <span class="text-xs text-slate-400 font-bold">-</span>
                                            </template>
                                        </td>

                                        <!-- Badge Status Ujian -->
                                        <td class="p-4 text-center">
                                            <template x-if="item.status === 'terkunci'">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-700 border border-rose-300 animate-pulse">
                                                    <i class="fa-solid fa-lock mr-1.5"></i> Terkunci
                                                </span>
                                            </template>
                                            <template x-if="item.status === 'sedang_mengerjakan'">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-ping"></span> Mengerjakan
                                                </span>
                                            </template>
                                            <template x-if="item.status === 'selesai'">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-600 border border-blue-200">
                                                    Selesai
                                                </span>
                                            </template>
                                            <template x-if="item.status === 'belum_mulai'">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-600 border border-amber-200">
                                                    Belum Mulai
                                                </span>
                                            </template>
                                        </td>

                                        <!-- Aksi Proctoring -->
                                        <td class="p-4 text-right">
                                            <div class="flex items-center justify-end space-x-1.5">
                                                <!-- Reset Session / Buka Kunci -->
                                                <button @click="resetSession(item.user_id)" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200" title="Reset Sesi Login & Buka Kunci Siswa">
                                                    <i class="fa-solid fa-arrow-rotate-left mr-1"></i> Reset
                                                </button>
                                                <!-- Paksa Selesai -->
                                                <template x-if="item.status !== 'selesai'">
                                                    <button @click="forceFinish(item.user_id, item.jadwal_id)" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white rounded-lg text-xs font-bold transition border border-rose-200" title="Hentikan / Paksa Selesai Ujian">
                                                        <i class="fa-solid fa-power-off mr-1"></i> Selesai
                                                    </button>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                <template x-if="siswaList.length === 0">
                                    <tr>
                                        <td colspan="7" class="p-12 text-center text-slate-400 font-semibold">
                                            Belum ada aktivitas pengerjaan siswa pada ujian yang aktif.
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

    <!-- Script Logic Alpine.js -->
    <script>
        function monitoringApp() {
            return {
                selectedJadwalId: '',
                siswaList: [],
                summary: { online: 0, warning: 0, selesai: 0, blocked: 0 },
                loading: false,
                toast: { show: false, message: '', type: 'success' },

                init() {
                    this.fetchData();
                    // Auto Refresh tiap 5 detik
                    setInterval(() => {
                        this.fetchData(true);
                    }, 5000);
                },

                fetchData(silent = false) {
                    if (!silent) this.loading = true;

                    let url = "{{ route('admin.monitoring-ujian.get-data') }}";
                    if (this.selectedJadwalId) {
                        url += '?jadwal_id=' + this.selectedJadwalId;
                    }

                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status) {
                            this.siswaList = res.data;
                            this.summary = res.summary;
                        }
                    })
                    .catch(err => console.error(err))
                    .finally(() => {
                        this.loading = false;
                    });
                },

                showToast(msg, type = 'success') {
                    this.toast = { show: true, message: msg, type: type };
                    setTimeout(() => { this.toast.show = false; }, 3500);
                },

                resetSession(userId) {
                    if (!confirm('Yakin ingin mereset sesi login & membuka kunci ujian siswa ini?')) return;

                    fetch(`/admin/monitoring-ujian/reset-session/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.showToast(res.message);
                        this.fetchData();
                    });
                },

                forceFinish(userId, jadwalId) {
                    if (!confirm('Yakin ingin memaksa mengakhiri ujian siswa ini? Nilai akan dihitung dari jawaban yang tersimpan.')) return;

                    fetch(`/admin/monitoring-ujian/force-finish/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ jadwal_id: jadwalId })
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.showToast(res.message);
                        this.fetchData();
                    });
                }
            }
        }
    </script>
</body>
</html>
