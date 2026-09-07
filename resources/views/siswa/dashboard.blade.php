<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SMAN 1 Kupang Timur</title>

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
<body class="bg-[#F8FAFC] text-slate-800 min-h-screen flex flex-col">

    <header class="bg-white border-b border-slate-200/80 px-4 sm:px-8 py-4 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center">
            <div class="bg-indigo-600 p-2.5 rounded-2xl text-white mr-3.5 shadow-md shadow-indigo-200">
                <i class="fa-solid fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <h1 class="font-bold text-xs text-slate-900 leading-snug tracking-normal font-serif-custom uppercase">SMAN 1 KUPANG TIMUR</h1>
                <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider mt-0.5">Portal Ujian Siswa</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 font-semibold">Siswa</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="h-10 w-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-colors shadow-sm" title="Keluar">
                    <i class="fa-solid fa-power-off text-sm"></i>
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 md:p-8">

        <!-- Banner Selamat Datang -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-3xl p-6 md:p-10 text-white shadow-xl shadow-indigo-100 mb-8 sm:mb-10 relative overflow-hidden">
            <div class="relative z-10">
                <span class="bg-white/20 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3 inline-block">
                    Selamat Datang
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold mb-2 font-serif-custom">Halo, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-indigo-100 font-medium max-w-xl text-xs sm:text-sm leading-relaxed">
                    Silakan pilih jadwal ujian yang tersedia di bawah ini. Pastikan Anda telah menerima token ujian resmi dari pengawas kelas.
                </p>
            </div>
        </div>

        <!-- Header Seksi Daftar Ujian -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h3 class="text-xl font-bold text-slate-800 font-serif-custom">Daftar Jadwal Ujian</h3>
            <span class="text-xs font-bold text-slate-500 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 shadow-sm self-start sm:self-auto">
                <i class="fa-regular fa-calendar-check text-indigo-500 mr-1.5"></i> {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>

        <!-- Grid Cards Jadwal Ujian -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($jadwal_ujians as $jadwal)
                @php
                    $statusUjian = $jadwal->status ?? 'belum_mulai';
                @endphp

                <div class="bg-white rounded-3xl p-6 border border-slate-200/70 shadow-sm hover:shadow-md transition-all flex flex-col relative group">
                    <!-- Accent Bar -->
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $statusUjian === 'berlangsung' ? 'bg-emerald-500' : ($statusUjian === 'selesai' ? 'bg-slate-300' : 'bg-amber-400') }} rounded-l-3xl"></div>

                    <div class="pl-2 flex-1">
                        <!-- Top Badges -->
                        <div class="flex items-center justify-between mb-3 gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 truncate">
                                {{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? 'Mata Pelajaran' }}
                            </span>

                            @if($statusUjian === 'berlangsung')
                                <span class="inline-flex items-center bg-emerald-50 text-emerald-600 text-[11px] font-bold px-2.5 py-1 rounded-full border border-emerald-200 flex-none">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Berlangsung
                                </span>
                            @elseif($statusUjian === 'selesai')
                                <span class="inline-flex items-center bg-slate-100 text-slate-500 text-[11px] font-bold px-2.5 py-1 rounded-full border border-slate-200 flex-none">
                                    <i class="fa-solid fa-check-double mr-1"></i> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center bg-amber-50 text-amber-700 text-[11px] font-bold px-2.5 py-1 rounded-full border border-amber-200 flex-none">
                                    <i class="fa-regular fa-clock mr-1"></i> Belum Mulai
                                </span>
                            @endif
                        </div>

                        <!-- Judul & Target Kelas -->
                        <h4 class="font-extrabold text-lg text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors">
                            {{ $jadwal->judul }}
                        </h4>

                        <p class="text-xs font-bold text-indigo-600 mb-4">
                            <i class="fa-solid fa-graduation-cap mr-1"></i>
                            {{ $jadwal->kelas === 'Semua Kelas' ? 'Semua Kelas' : 'Kelas ' . $jadwal->kelas }}
                        </p>

                        <!-- Box Informasi Tanggal & Durasi -->
                        <div class="space-y-2 mb-6 bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                            <div class="flex items-center text-xs font-semibold text-slate-600">
                                <i class="fa-regular fa-calendar-days text-indigo-500 w-5"></i>
                                <span class="w-20 text-slate-400">Tanggal:</span>
                                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="flex items-center text-xs font-semibold text-slate-600">
                                <i class="fa-regular fa-clock text-amber-500 w-5"></i>
                                <span class="w-20 text-slate-400">Durasi:</span>
                                <span class="font-bold text-slate-700">{{ $jadwal->durasi }} Menit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pl-2 mt-auto">
                        @if($statusUjian === 'berlangsung')
                            <a href="{{ route('siswa.ujian.token', $jadwal->id) }}" class="block w-full text-center py-3.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-indigo-200 transition-all">
                                Masuk Ujian <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        @elseif($statusUjian === 'selesai')
                            <button disabled class="block w-full text-center py-3.5 bg-slate-100 text-slate-400 font-extrabold text-sm rounded-xl cursor-not-allowed">
                                Ujian Telah Selesai
                            </button>
                        @else
                            <button disabled class="block w-full text-center py-3.5 bg-slate-100 text-slate-400 font-extrabold text-sm rounded-xl cursor-not-allowed">
                                Belum Waktunya Ujian
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-200/60 shadow-sm">
                    <div class="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-regular fa-calendar-xmark text-2xl text-slate-400"></i>
                    </div>
                    <p class="font-extrabold text-slate-700 text-base">Tidak ada jadwal ujian tersedia</p>
                    <p class="text-xs text-slate-400 mt-1">Belum ada ujian yang dijadwalkan untuk akun Anda hari ini.</p>
                </div>
            @endforelse

        </div>
    </main>

</body>
</html>
