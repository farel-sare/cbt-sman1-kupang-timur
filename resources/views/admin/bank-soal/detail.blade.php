<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Soal {{ $mapel->nama ?? $mapel->name }} - SMAN 1 Kupang Timur</title>

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
            <a href="{{ route('admin.bank-soal.index') }}" class="flex items-center px-4 py-3 bg-indigo-600 rounded-xl text-white font-semibold shadow-lg shadow-indigo-900/20 transition-all">
                <i class="fa-solid fa-database w-6 text-center text-indigo-200 mr-2"></i> Bank Soal
            </a>
            <a href="{{ route('admin.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-indigo-400 mr-2"></i> Jadwal Ujian
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-sm font-semibold text-slate-500 bg-slate-100/80 px-4 py-2 rounded-full">
                <i class="fa-solid fa-book-open mr-2 text-indigo-500"></i> Detail Soal: {{ $mapel->nama ?? $mapel->name }}
            </div>
            <a href="{{ route('admin.bank-soal.index', ['kelas' => request('kelas')]) }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl transition flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Rekap
            </a>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-serif-custom">{{ $mapel->nama ?? $mapel->name }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Daftar butir pertanyaan {{ request('kelas') ? 'Kelas ' . request('kelas') : 'Semua Kelas' }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 text-center w-16">No</th>
                                    <th class="p-5">Pertanyaan & Opsi</th>
                                    <th class="p-5 text-center w-28">Kunci</th>
                                    <th class="p-5 text-right pr-6 w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600 divide-y divide-slate-100">
                                @forelse($soals as $index => $soal)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-5 text-center font-semibold text-slate-400">
                                        {{ $soals->firstItem() + $index }}
                                    </td>
                                    <td class="p-5">
                                        <div class="mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                Kelas {{ $soal->kelas }}
                                            </span>
                                        </div>
                                        <p class="font-bold text-slate-800 mb-2">{{ $soal->pertanyaan }}</p>
                                        <div class="grid grid-cols-2 gap-2 text-xs text-slate-600">
                                            <div>A. {{ $soal->opsi_a }}</div>
                                            <div>B. {{ $soal->opsi_b }}</div>
                                            <div>C. {{ $soal->opsi_c }}</div>
                                            <div>D. {{ $soal->opsi_d }}</div>
                                            @if($soal->opsi_e)<div>E. {{ $soal->opsi_e }}</div>@endif
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-emerald-100 text-emerald-800 font-extrabold px-3 py-1 rounded-lg uppercase text-xs border border-emerald-200">
                                            {{ $soal->kunci_jawaban }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-right pr-6">
                                        <form action="{{ route('admin.bank-soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white h-9 w-9 rounded-xl inline-flex items-center justify-center transition-colors shadow-sm" title="Hapus Soal">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-400">
                                        Belum ada soal untuk mata pelajaran ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($soals->hasPages())
                    <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                        {{ $soals->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
