<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileSidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Ujian - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

    <!-- Sidebar Modern (Dark Slate) -->
    <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
           class="fixed md:static inset-y-0 left-0 w-72 bg-slate-900 text-slate-300 flex flex-col flex-none shadow-2xl z-40 transition-transform duration-300 ease-in-out">
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

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-house w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Ujian</div>

            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-database w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Bank Soal
            </a>

            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-indigo-200 mr-2"></i> Jadwal Ujian
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
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-4 sm:px-8 shadow-sm z-10 flex-none">
            <div class="flex items-center space-x-3">
                <button @click="mobileSidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100/80 px-4 py-2 rounded-full">
                    <i class="fa-solid fa-calendar-alt mr-2 text-indigo-500"></i> Manajemen Jadwal Ujian
                </div>
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

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header Halaman & Tombol Aksi -->
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight font-serif-custom">Jadwal Ujian Aktif</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Kelola seluruh pelaksanaan sesi ujian siswa.</p>
                    </div>
                    <a href="{{ route('admin.jadwal-ujian.create') }}" class="bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 font-semibold flex items-center transition-all duration-200">
                        <i class="fa-solid fa-plus mr-2 text-sm"></i> Buat Jadwal Ujian
                    </a>
                </div>

                <!-- Alert Sukses -->
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-check mr-3 text-emerald-600 text-lg"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Tabel Data Jadwal Ujian -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 text-center w-16">No</th>
                                    <th class="p-5">Judul Ujian</th>
                                    <th class="p-5">Mata Pelajaran</th>
                                    <th class="p-5 text-center">Kelas</th>
                                    <th class="p-5 text-center">Tanggal Pelaksanaan</th>
                                    <th class="p-5 text-center">Token</th>
                                    <th class="p-5 text-center">Status</th>
                                    <th class="p-5 text-right pr-6 w-44">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600 divide-y divide-slate-100">
                                @forelse($jadwalUjians as $index => $jadwal)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="p-5 text-center font-semibold text-slate-400">
                                        {{ $jadwalUjians->firstItem() + $index }}
                                    </td>
                                    <td class="p-5 font-bold text-slate-800">
                                        {{ $jadwal->judul }}
                                    </td>
                                    <td class="p-5 font-semibold text-slate-700">
                                        {{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-' }}
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200 inline-block">
                                            {{ $jadwal->kelas === 'Semua Kelas' ? 'Semua Kelas' : 'Kelas ' . $jadwal->kelas }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-center font-medium text-slate-600">
                                        <div>
                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-slate-400 font-normal mt-0.5">
                                            {{ $jadwal->durasi }} Menit
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <span class="font-mono font-bold bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg border border-amber-200 text-xs tracking-wider">
                                                {{ $jadwal->token ?? '-' }}
                                            </span>
                                            <form action="{{ route('admin.jadwal-ujian.generate-token', $jadwal->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-amber-600 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 p-1.5 rounded-lg border border-amber-200 transition" title="Generate Token Baru">
                                                    <i class="fa-solid fa-arrows-rotate text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        @if(($jadwal->status ?? '') === 'berlangsung')
                                            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200 inline-flex items-center">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Berlangsung
                                            </span>
                                        @elseif(($jadwal->status ?? '') === 'selesai')
                                            <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1 rounded-full border border-slate-200">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-200">
                                                Belum Mulai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-5 text-right pr-6">
                                        <div class="flex justify-end items-center space-x-2">
                                            <!-- Tombol Toggle Buka / Tutup Ujian -->
                                            <form action="{{ route('admin.jadwal-ujian.toggle-status', $jadwal->id) }}" method="POST" class="inline">
                                                @csrf
                                                @if($jadwal->status === 'berlangsung')
                                                    <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white px-3 py-1.5 rounded-xl border border-rose-200 text-xs font-bold transition flex items-center" title="Tutup Ujian">
                                                        <i class="fa-solid fa-stop mr-1"></i> Tutup
                                                    </button>
                                                @else
                                                    <button type="submit" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-xl border border-emerald-200 text-xs font-bold transition flex items-center" title="Buka Ujian">
                                                        <i class="fa-solid fa-play mr-1"></i> Buka Ujian
                                                    </button>
                                                @endif
                                            </form>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.jadwal-ujian.edit', $jadwal->id) }}" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white h-8 w-8 rounded-xl inline-flex items-center justify-center transition shadow-sm" title="Edit Jadwal">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.jadwal-ujian.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ujian ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white h-8 w-8 rounded-xl inline-flex items-center justify-center transition shadow-sm" title="Hapus Jadwal">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="p-12 text-center text-slate-400 font-semibold">
                                        Belum ada jadwal ujian yang dibuat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($jadwalUjians->hasPages())
                    <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                        {{ $jadwalUjians->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
