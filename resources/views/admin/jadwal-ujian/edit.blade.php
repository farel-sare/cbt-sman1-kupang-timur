<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Ujian - SMAN 1 Kupang Timur</title>

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

    <!-- Sidebar Modern -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-none shadow-2xl z-20">
        <div class="h-20 flex items-center px-5 border-b border-slate-800 bg-slate-950/50">
            <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-7 w-7 object-contain">
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
            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-indigo-200 mr-2"></i> Jadwal Ujian
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-sm font-semibold text-slate-500 bg-slate-100/80 px-4 py-2 rounded-full">
                <i class="fa-solid fa-pen-to-square mr-2 text-indigo-500"></i> Edit Jadwal Ujian
            </div>
            <a href="{{ route('admin.jadwal-ujian.index') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl transition flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-3xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-slate-800 font-serif-custom">Edit Jadwal Ujian</h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Ubah pengaturan waktu dan mata pelajaran ujian.</p>
                </div>

                @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm shadow-sm">
                    <ul class="list-disc pl-5 font-semibold space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200/60">
                    <form action="{{ route('admin.jadwal-ujian.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Judul Ujian -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Ujian</label>
                                <input type="text" name="judul" value="{{ old('judul', $jadwal->judul ?? $jadwal->nama_ujian) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>

                            <!-- Mata Pelajaran -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Mata Pelajaran</label>
                                <select name="mata_pelajaran_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach($mataPelajarans as $mapel)
                                        <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $jadwal->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama ?? $mapel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Waktu Mulai & Waktu Selesai -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Waktu Mulai</label>
                                    <input type="datetime-local" name="waktu_mulai" value="{{ old('waktu_mulai', date('Y-m-d\TH:i', strtotime($jadwal->waktu_mulai))) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Waktu Selesai</label>
                                    <input type="datetime-local" name="waktu_selesai" value="{{ old('waktu_selesai', date('Y-m-d\TH:i', strtotime($jadwal->waktu_selesai))) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>
                            </div>

                            <!-- Durasi (Menit) -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Durasi (Menit)</label>
                                <input type="number" name="durasi" value="{{ old('durasi', $jadwal->durasi) }}" min="1" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end space-x-3">
                            <a href="{{ route('admin.jadwal-ujian.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-sm transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-indigo-200 transition">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
