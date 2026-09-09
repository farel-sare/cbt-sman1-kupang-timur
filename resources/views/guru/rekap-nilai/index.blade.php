<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai Siswa - SMAN 1 Kupang Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar Guru -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-none shadow-2xl z-20">
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            </div>
            <div class="overflow-hidden">
                <h1 class="font-bold text-xs text-white uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                <p class="text-[10px] text-blue-400 font-semibold uppercase mt-0.5">PANEL GURU</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition">
                <i class="fa-solid fa-house w-6 text-center mr-2"></i> Dashboard
            </a>
            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase">KELOLA EVALUASI</div>
            <a href="{{ route('guru.bank-soal.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition">
                <i class="fa-solid fa-database w-6 text-center mr-2"></i> Bank Soal Saya
            </a>
            <a href="{{ route('guru.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition">
                <i class="fa-solid fa-calendar-alt w-6 text-center mr-2"></i> Jadwal Ujian
            </a>
            <a href="{{ route('guru.monitoring.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition">
                <i class="fa-solid fa-desktop w-6 text-center mr-2"></i> Monitoring Realtime
            </a>
            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase">LAPORAN & NILAI</div>
            <a href="{{ route('guru.rekap-nilai.index') }}" class="flex items-center px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-900/30 transition">
                <i class="fa-solid fa-chart-line w-6 text-center text-blue-200 mr-2"></i> Rekap Nilai Siswa
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-xs font-bold text-blue-700 bg-blue-50 px-4 py-2 rounded-full border border-blue-100">
                <i class="fa-solid fa-chart-line mr-2"></i> Laporan Nilai Siswa
            </div>
            <span class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</span>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Rekap Nilai Siswa</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Daftar rekapitulasi nilai ujian per mata pelajaran Anda.</p>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="p-4 text-center">No</th>
                                    <th class="p-4">Nama Ujian</th>
                                    <th class="p-4 text-center">Kelas Target</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                                @forelse($jadwals as $index => $jadwal)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 text-center font-bold text-slate-400">{{ $jadwals->firstItem() + $index }}</td>
                                    <td class="p-4 font-bold text-slate-800">{{ $jadwal->nama_ujian }}</td>
                                    <td class="p-4 text-center"><span class="bg-slate-100 px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200">{{ $jadwal->kelas }}</span></td>
                                    <td class="p-4 text-center">
                                        <button class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            <i class="fa-solid fa-download mr-1"></i> Cetak / Export Nilai
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="p-8 text-center text-slate-400 font-semibold">Belum ada nilai ujian yang tersedia.</td></tr>
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
