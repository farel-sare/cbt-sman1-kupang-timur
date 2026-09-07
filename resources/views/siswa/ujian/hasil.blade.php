<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian - {{ $jadwal->judul }}</title>

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
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-lg w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100 my-8">
        <!-- Header Card Kartu Hasil -->
        <div class="bg-indigo-600 p-8 text-white text-center relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>

            <div class="h-20 w-20 bg-white/20 backdrop-blur-md rounded-3xl flex items-center justify-center mx-auto mb-4 border border-white/20 shadow-lg">
                <i class="fa-solid fa-trophy text-3xl text-amber-300"></i>
            </div>

            <h2 class="text-2xl font-bold font-serif-custom">Ujian Telah Selesai!</h2>
            <p class="text-xs text-indigo-200 mt-1 font-medium">Terima kasih telah menyelesaikan ujian dengan jujur.</p>
        </div>

        <!-- Detail Informasi Ujian & Peserta -->
        <div class="p-6 bg-slate-50/70 border-b border-slate-100 space-y-3 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                <span class="font-bold text-slate-800">{{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase">Judul Ujian</span>
                <span class="font-semibold text-slate-700">{{ $jadwal->judul }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase">Nama Peserta</span>
                <span class="font-bold text-indigo-600">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <!-- Skor & Statistik Rincian -->
        <div class="p-8 text-center">

            <!-- Box Skor Utama -->
            <div class="mb-8 p-6 bg-slate-50 rounded-3xl border border-slate-200/60 inline-block w-full">
                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-2">Nilai Akhir Anda</p>
                <div class="text-5xl font-extrabold {{ $nilai >= 75 ? 'text-emerald-600' : 'text-indigo-600' }}">
                    {{ number_format($nilai, 1) }}
                </div>
                <span class="inline-block mt-3 px-4 py-1.5 rounded-full text-xs font-bold {{ $nilai >= 75 ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-indigo-100 text-indigo-700 border border-indigo-200' }}">
                    {{ $nilai >= 75 ? 'Tuntas / Sangat Baik' : 'Telah Terekam' }}
                </span>
            </div>

            <!-- Grid Rincian Jawaban -->
            <div class="grid grid-cols-3 gap-3 mb-8">
                <!-- Total Soal -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Soal</p>
                    <p class="text-xl font-extrabold text-slate-800">{{ $totalSoal }}</p>
                </div>
                <!-- Jawaban Benar -->
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Benar</p>
                    <p class="text-xl font-extrabold text-emerald-700">{{ $jawabanBenar }}</p>
                </div>
                <!-- Jawaban Salah -->
                <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100">
                    <p class="text-[10px] font-bold text-rose-600 uppercase mb-1">Salah</p>
                    <p class="text-xl font-extrabold text-rose-700">{{ $totalSoal - $jawabanBenar }}</p>
                </div>
            </div>

            <!-- Tombol Kembali ke Dashboard -->
            <a href="{{ route('siswa.dashboard') }}" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all text-sm flex items-center justify-center">
                <i class="fa-solid fa-house mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>
