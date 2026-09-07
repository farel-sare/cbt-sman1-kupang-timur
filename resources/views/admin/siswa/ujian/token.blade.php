<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Token Ujian - SMAN 1 Kupang Timur</title>

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

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
        <!-- Header Card -->
        <div class="bg-indigo-600 p-8 text-white text-center relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>

            <div class="h-16 w-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                <i class="fa-solid fa-key text-2xl text-white"></i>
            </div>

            <h2 class="text-xl font-bold font-serif-custom">Konfirmasi Token Ujian</h2>
            <p class="text-xs text-indigo-200 mt-1">Masukkan kode token yang diberikan oleh pengawas/admin.</p>
        </div>

        <!-- Detail Informasi Ujian -->
        <div class="p-6 bg-slate-50/50 border-b border-slate-100 space-y-3 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                <span class="font-bold text-slate-800">{{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase">Judul Ujian</span>
                <span class="font-semibold text-slate-700">{{ $jadwal->judul }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase">Durasi Pengerjaan</span>
                <span class="font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100 text-xs">
                    <i class="fa-regular fa-clock mr-1"></i> {{ $jadwal->durasi }} Menit
                </span>
            </div>
        </div>

        <!-- Form Verifikasi Token -->
        <div class="p-8">
            <!-- Alert Error Token -->
            @if($errors->has('token'))
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-2xl text-xs font-bold flex items-center shadow-sm">
                <i class="fa-solid fa-triangle-exclamation mr-3 text-base flex-none"></i>
                <span>{{ $errors->first('token') }}</span>
            </div>
            @endif

            <form action="{{ route('siswa.ujian.verify', $jadwal->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 text-center">
                        Kode Token Ujian (6 Karakter)
                    </label>
                    <input type="text"
                           name="token"
                           maxlength="6"
                           required
                           placeholder="Contoh: X8K2P9"
                           autocomplete="off"
                           class="w-full text-center px-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-2xl text-xl font-extrabold uppercase tracking-widest text-indigo-600 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 focus:outline-none transition-all placeholder:text-slate-300 placeholder:font-medium placeholder:tracking-normal">
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all text-sm flex items-center justify-center">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Mulai Kerjakan Ujian
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('siswa.dashboard') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition inline-flex items-center">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

</body>
</html>
