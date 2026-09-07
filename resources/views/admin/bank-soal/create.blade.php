<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileSidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal - CBT SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
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
                    <p class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase mt-0.5">Panel Admin</p>
                </div>
            </div>
            <button @click="mobileSidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Menu Navigasi Lengkap -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-house w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Ujian</div>

            <!-- Active Menu: Bank Soal -->
            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-900/20 transition-all">
                <i class="fa-solid fa-database w-6 text-center text-blue-200 mr-2"></i> Bank Soal
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

            <a href="{{ route('admin.monitoring-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-desktop w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Monitoring Ujian
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

    <!-- Main Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-4 sm:px-8 shadow-sm z-10 flex-none">
            <div class="flex items-center space-x-3">
                <button @click="mobileSidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full flex items-center">
                    <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i> Tambah Soal Ujian
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

        <!-- Main Body Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-6 sm:p-8">

                    <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-800">Form Input Soal Baru</h2>
                        <a href="{{ route('admin.bank-soal.index') }}" class="text-xs sm:text-sm font-semibold text-slate-500 hover:text-blue-600 bg-slate-50 hover:bg-blue-50 px-3.5 py-2 rounded-xl transition">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm">
                            <ul class="list-disc pl-5 space-y-1 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.bank-soal.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mata Pelajaran <span class="text-rose-500">*</span></label>
                            <select name="mata_pelajaran_id" required class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 bg-slate-50/50">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mataPelajarans as $mapel)
                                    <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pertanyaan Soal <span class="text-rose-500">*</span></label>
                            <textarea name="pertanyaan" rows="4" required placeholder="Tuliskan teks pertanyaan soal di sini..." class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm p-3 bg-slate-50/50">{{ old('pertanyaan') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilihan A <span class="text-rose-500">*</span></label>
                                <input type="text" name="opsi_a" value="{{ old('opsi_a') }}" required placeholder="Jawaban A" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 px-4 bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilihan B <span class="text-rose-500">*</span></label>
                                <input type="text" name="opsi_b" value="{{ old('opsi_b') }}" required placeholder="Jawaban B" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 px-4 bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilihan C <span class="text-rose-500">*</span></label>
                                <input type="text" name="opsi_c" value="{{ old('opsi_c') }}" required placeholder="Jawaban C" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 px-4 bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pilihan D <span class="text-rose-500">*</span></label>
                                <input type="text" name="opsi_d" value="{{ old('opsi_d') }}" required placeholder="Jawaban D" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 px-4 bg-slate-50/50">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilihan E (Opsional)</label>
                            <input type="text" name="opsi_e" value="{{ old('opsi_e') }}" placeholder="Jawaban E" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 px-4 bg-slate-50/50">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kunci Jawaban <span class="text-rose-500">*</span></label>
                            <select name="kunci_jawaban" required class="w-full md:w-1/3 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm shadow-sm py-3 bg-slate-50/50">
                                <option value="">-- Pilih Kunci Jawaban --</option>
                                <option value="a" {{ old('kunci_jawaban') == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('kunci_jawaban') == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('kunci_jawaban') == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('kunci_jawaban') == 'd' ? 'selected' : '' }}>D</option>
                                <option value="e" {{ old('kunci_jawaban') == 'e' ? 'selected' : '' }}>E</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.bank-soal.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-sm shadow-sm transition-all">Batal</a>
                            <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg shadow-blue-200 transition-all">
                                <i class="fa-solid fa-save mr-2"></i> Simpan Soal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </main>
    </div>
</body>
</html>
