<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileSidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jadwal Ujian - SMAN 1 Kupang Timur</title>

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

    <!-- Sidebar Modern -->
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
                    <i class="fa-solid fa-calendar-plus mr-2 text-indigo-500"></i> Buat Jadwal Ujian Baru
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ auth()->user()->role ?? 'Administrator' }}</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
            <div class="max-w-4xl mx-auto space-y-6">

                <!-- Header Halaman -->
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight font-serif-custom">Tambah Sesi Ujian</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Lengkapi formulir di bawah untuk menjadwalkan sesi ujian siswa.</p>
                    </div>
                    <a href="{{ route('admin.jadwal-ujian.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition flex items-center">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>

                <!-- Error Alert -->
                @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-6 sm:p-8">
                    <form action="{{ route('admin.jadwal-ujian.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Judul Ujian -->
                        <div>
                            <label for="judul" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Ujian <span class="text-rose-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required placeholder="Contoh: Penilaian Akhir Semester Ganjil - Matematika X"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        <!-- Mata Pelajaran & Target Kelas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="mata_pelajaran_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Mata Pelajaran <span class="text-rose-500">*</span></label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" required
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach($mataPelajarans as $mapel)
                                        <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama ?? $mapel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="kelas" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target Kelas <span class="text-rose-500">*</span></label>
                                <select name="kelas" id="kelas" required
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="Semua Kelas" {{ old('kelas') == 'Semua Kelas' ? 'selected' : '' }}>Semua Kelas</option>
                                    <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                                    <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                                    <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tanggal Ujian -->
                        <div>
                            <label for="tanggal" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Pelaksanaan Ujian <span class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        </div>

                        <!-- Durasi & Token -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="durasi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Durasi Ujian (Menit) <span class="text-rose-500">*</span></label>
                                <input type="number" name="durasi" id="durasi" min="1" value="{{ old('durasi', 90) }}" required placeholder="Contoh: 90"
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <div>
                                <label for="token" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Token Ujian (Dibuat Otomatis)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-key text-slate-400"></i>
                                    </div>
                                    <input type="text" name="token" id="token" readonly value="{{ $token ?? strtoupper(\Illuminate\Support\Str::random(6)) }}"
                                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-amber-50/60 text-slate-800 font-mono font-extrabold text-sm tracking-widest">
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1 font-medium">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Token ini akan digunakan siswa untuk membuka ujian.
                                </p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.jadwal-ujian.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition">
                                <i class="fa-solid fa-save mr-2"></i> Simpan Jadwal Ujian
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
