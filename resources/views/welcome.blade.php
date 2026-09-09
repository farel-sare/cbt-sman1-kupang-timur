<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Ujian - SMA Negeri 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800 selection:bg-indigo-500 selection:text-white overflow-x-hidden">

    <!-- Background Glow Effects -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-200/50 rounded-full blur-3xl opacity-70 animate-pulse"></div>
        <div class="absolute top-1/3 -right-40 w-[30rem] h-[30rem] bg-blue-200/50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 left-1/3 w-[28rem] h-[28rem] bg-purple-200/40 rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Navbar Sticky -->
    <nav x-data="{ mobileNavOpen: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 fixed w-full z-50 top-0 left-0 transition-all">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-3.5">

            <!-- Logo & Title -->
            <a href="/" class="flex items-center space-x-3 group">
                <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo Tut Wuri" class="h-8 w-8 object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Portal Ujian</span>
                    <span class="text-base font-bold text-slate-900 font-serif-custom tracking-tight group-hover:text-indigo-600 transition-colors">SMAN 1 Kupang Timur</span>
                </div>
            </a>

            <!-- Action Button & Hamburger -->
            <div class="flex md:order-2 items-center space-x-2 sm:space-x-3">
                @if (Route::has('login'))
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 font-bold rounded-xl text-xs sm:text-sm px-4 sm:px-5 py-2.5 text-center shadow-lg shadow-indigo-200 transition-all duration-200">
                                <i class="fa-solid fa-gauge mr-2"></i> Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 font-bold rounded-xl text-xs sm:text-sm px-4 sm:px-5 py-2.5 text-center shadow-lg shadow-indigo-200 transition-all duration-200">
                                <i class="fa-solid fa-graduation-cap mr-2"></i> Dashboard Ujian
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 font-bold rounded-xl text-xs sm:text-sm px-4 sm:px-5 py-2.5 text-center shadow-lg shadow-indigo-200 transition-all duration-200">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk Portal
                        </a>
                    @endauth
                @endif

                <!-- Hamburger Button (Mobile) -->
                <button @click="mobileNavOpen = !mobileNavOpen" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-slate-500 rounded-xl md:hidden hover:bg-slate-100 focus:outline-none">
                    <i class="fa-solid" :class="mobileNavOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                </button>
            </div>

            <!-- Nav Links -->
            <div :class="mobileNavOpen ? 'block' : 'hidden'" class="items-center justify-between w-full md:flex md:w-auto md:order-1 transition-all" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-semibold border border-slate-200/80 rounded-2xl bg-white md:bg-transparent md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 text-sm shadow-lg md:shadow-none">
                    <li><a @click="mobileNavOpen = false" href="#beranda" class="block py-2 px-3 text-slate-700 hover:text-indigo-600 transition-colors">Beranda</a></li>
                    <li><a @click="mobileNavOpen = false" href="#profil" class="block py-2 px-3 text-slate-700 hover:text-indigo-600 transition-colors">Profil</a></li>
                    <li><a @click="mobileNavOpen = false" href="#fitur" class="block py-2 px-3 text-slate-700 hover:text-indigo-600 transition-colors">Fitur Keunggulan</a></li>
                    <li><a @click="mobileNavOpen = false" href="#panduan" class="block py-2 px-3 text-slate-700 hover:text-indigo-600 transition-colors">Cara Ujian</a></li>
                    <li><a @click="mobileNavOpen = false" href="#kontak" class="block py-2 px-3 text-slate-700 hover:text-indigo-600 transition-colors">Kontak Bantuan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- SECTION: BERANDA / HERO -->
    <section id="beranda" class="relative z-10 pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Left Column: Content -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold mb-6 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-ping"></span>
                        Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }} • System Ready
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-6">
                        Portal Ujian Terpadu <br/>
                        <span class="bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent font-serif-custom">SMAN 1 Kupang Timur</span>
                    </h1>

                    <p class="text-sm sm:text-lg text-slate-600 font-medium leading-relaxed mb-8 max-w-2xl mx-auto lg:mx-0">
                        Platform ujian yang cepat, transparan, dan aman. Dirancang untuk memberikan pengalaman pengerjaan ujian tanpa hambatan bagi seluruh siswa SMAN 1 Kupang Timur.
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center py-3.5 px-7 text-base font-bold text-white rounded-2xl bg-indigo-600 hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95">
                            <i class="fa-solid fa-paper-plane mr-2.5"></i> Mulai Ujian Sekarang
                        </a>
                        <a href="#panduan" class="inline-flex justify-center items-center py-3.5 px-7 text-base font-bold text-slate-700 rounded-2xl bg-white border border-slate-200 hover:bg-slate-100 shadow-sm transition-all duration-200">
                            <i class="fa-solid fa-circle-play mr-2 text-indigo-500"></i> Panduan Siswa
                        </a>
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-200/80 grid grid-cols-3 gap-6 max-w-md mx-auto lg:mx-0 text-center lg:text-left">
                        <div>
                            <p class="text-xl sm:text-2xl font-extrabold text-slate-900">100%</p>
                            <p class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-0.5">Digital & Paperless</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-extrabold text-slate-900">Real-Time</p>
                            <p class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-0.5">Auto Saving</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl font-extrabold text-slate-900">Secure</p>
                            <p class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-0.5">Anti-Cheat System</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Foto Sekolah -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <div class="absolute -inset-2 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-[2.5rem] blur-2xl opacity-25"></div>

                        <div class="relative bg-white rounded-3xl p-3 shadow-2xl border border-slate-200/80">
                            <div class="overflow-hidden rounded-2xl relative group">
                                <img src="{{ asset('images/sekolah.jpeg') }}" alt="Gedung SMAN 1 Kupang Timur" class="w-full h-[360px] sm:h-[420px] object-cover group-hover:scale-105 transition-transform duration-500">

                                <div class="absolute bottom-4 left-4 right-4 bg-slate-900/80 backdrop-blur-md text-white p-4 rounded-2xl border border-white/10 shadow-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-lg flex-none">
                                            <i class="fa-solid fa-school"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-extrabold tracking-wider text-indigo-300">Gedung</p>
                                            <p class="text-sm font-bold text-white">SMAN 1 Kupang Timur</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: PROFIL -->
    <section id="profil" class="relative z-10 py-20 bg-white border-y border-slate-200/60">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div>
                    <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Tentang Sistem</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-4 mb-6 font-serif-custom">
                        Mewujudkan Digitalisasi Sekolah yang Terintegrasi
                    </h2>
                    <p class="text-slate-600 leading-relaxed font-medium mb-4">
                        Sistem ini dirancang khusus untuk memenuhi standar evaluasi modern di <strong class="text-slate-800">SMA Negeri 1 Kupang Timur</strong>. Kami bertransisi penuh dari ujian berbasis kertas ke ekosistem digital demi efisiensi, keakuratan data, dan transparansi.
                    </p>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        Melalui portal ini, bapak/ibu guru dapat mengelola bank soal secara fleksibel, serta melihat hasil rekapitulasi nilai siswa secara instan tanpa perlu pemeriksaan manual.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Evaluasi Efisien</h3>
                        <p class="text-xs text-slate-500 font-medium">Ujian dilakukan serentak menggunakan perangkat laptop atau HP.</p>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Analisis Otomatis</h3>
                        <p class="text-xs text-slate-500 font-medium">Hasil pengerjaan terhitung otomatis dan langsung tersimpan aman.</p>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Ramah Lingkungan</h3>
                        <p class="text-xs text-slate-500 font-medium">Mengurangi pemakaian kertas ujian hingga 100%.</p>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-1">Real-Time Sync</h3>
                        <p class="text-xs text-slate-500 font-medium">Respon jawaban tersimpan tiap detik untuk cegah data hilang.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: FITUR -->
    <section id="fitur" class="relative z-10 py-20 bg-slate-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Infrastruktur Unggulan</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3 mb-4 font-serif-custom">
                    Fitur Canggih Pendukung Ujian
                </h2>
                <p class="text-slate-600 font-medium">Dikembangkan dengan standar keamanan tinggi untuk menjamin kelancaran ujian.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="bg-white p-8 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                        <i class="fa-solid fa-shield-cat"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Anti-Cheat Protection</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">Peringatan dan penguncian otomatis jika siswa terdeteksi berpindah aplikasi atau tab browser saat ujian berlangsung.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Auto-Save Realtime</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">Setiap pilihan jawaban tersimpan secara instan di database server. Aman meskipun HP mati atau mati listrik.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                        <i class="fa-solid fa-shuffle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Pengacak Soal & Opsi</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">Nomor soal dan pilihan jawaban (A, B, C, D, E) diacak otomatis untuk setiap siswa guna mencegah kecurangan antar-teman.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Sistem Token Dinamis</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">Sesi ujian dilindungi kode token 6-digit acak yang hanya dibagikan oleh pengawas saat ujian siap dimulai.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                        <i class="fa-solid fa-desktop"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Multi-Device Support</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">Desain antarmuka fleksibel dan responsif. Kompatibel penuh dengan Laptop, Tablet, PC Desktop, maupun Smartphone.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Live Monitoring Admin</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed">Proktor dan guru pengawas dapat memantau progres pengerjaan dan status koneksi siswa secara langsung dari dashboard.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: PANDUAN -->
    <section id="panduan" class="relative z-10 py-20 bg-white border-t border-slate-200/60">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Langkah Pengerjaan</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3 mb-4 font-serif-custom">
                    Langkah-Langkah Mengikuti Ujian
                </h2>
                <p class="text-slate-600 font-medium">Ikuti 4 langkah sederhana berikut untuk menyelesaikan sesi ujian Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/70 text-center relative group hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-extrabold mx-auto mb-5 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Login Siswa</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Masukkan NIS/Username dan password resmi yang diberikan oleh panitia ujian sekolah.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/70 text-center relative group hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-extrabold mx-auto mb-5 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Verifikasi Token</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Pilih jadwal ujian aktif dan ketikkan 6-digit Token rahasia dari Bapak/Ibu Pengawas Ruang.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/70 text-center relative group hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-extrabold mx-auto mb-5 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Kerjakan Soal</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Pilih jawaban paling tepat. Perhatikan sisa waktu pada timer di pojok kanan atas layar.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/70 text-center relative group hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-extrabold mx-auto mb-5 shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                        4
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Selesaikan Ujian</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">Periksa kembali lembar jawaban, lalu tekan tombol "Selesai" untuk mengakhiri sesi ujian.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: KONTAK -->
    <section id="kontak" class="relative z-10 py-20 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <div class="lg:col-span-7">
                    <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Bantuan Teknis</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3 mb-4 font-serif-custom">
                        Butuh Bantuan Kendala Ujian?
                    </h2>
                    <p class="text-slate-600 font-medium leading-relaxed mb-8">
                        Tim Proktor dan IT SMAN 1 Kupang Timur siap membantu Anda jika mengalami kendala akun, gagal login, atau gangguan koneksi saat pengerjaan ujian.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start p-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg flex-none mr-4">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Alamat Sekolah</h4>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Jl. Timor Raya, Oesao, Kec. Kupang Timur, Kab. Kupang, Nusa Tenggara Timur</p>
                            </div>
                        </div>

                        <div class="flex items-start p-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg flex-none mr-4">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Email Layanan</h4>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">admincbt@sman1kupangtimur.sch.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white rounded-3xl p-8 shadow-2xl relative overflow-hidden border border-slate-800">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl"></div>

                        <h3 class="text-2xl font-bold font-serif-custom mb-3">Pusat Helpdesk Proktor</h3>
                        <p class="text-xs text-slate-300 font-medium leading-relaxed mb-6">
                            Mengalami lupa password atau butuh reset sesi karena HP mati saat ujian berlangsung? Segera laporkan ke Tim IT Proktor.
                        </p>

                        <a href="https://wa.me/6281234567890" target="_blank" class="w-full inline-flex justify-center items-center py-3.5 px-6 bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white font-bold rounded-2xl shadow-lg shadow-emerald-900/30 transition-all duration-200">
                            <i class="fa-brands fa-whatsapp text-lg mr-2.5"></i> Hubungi WhatsApp Proktor
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">

                <div class="md:col-span-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-white p-1 rounded-lg">
                            <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-6 w-6 object-contain">
                        </div>
                        <span class="text-lg font-bold text-white font-serif-custom">SMAN 1 Kupang Timur</span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed max-w-md">
                        Platform Ujian Berbasis Komputer & Mobile (CBT) resmi untuk mendukung proses evaluasi akademik yang objektif, transparan, dan modern.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-xs font-semibold">
                        <li><a href="#beranda" class="hover:text-indigo-400 transition-colors">Beranda</a></li>
                        <li><a href="#profil" class="hover:text-indigo-400 transition-colors">Profil Sistem</a></li>
                        <li><a href="#fitur" class="hover:text-indigo-400 transition-colors">Fitur Unggulan</a></li>
                        <li><a href="#panduan" class="hover:text-indigo-400 transition-colors">Panduan Siswa</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Akses Masuk</h4>
                    <ul class="space-y-2 text-xs font-semibold">
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-400 transition-colors"><i class="fa-solid fa-angle-right mr-1"></i> Login Siswa</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-400 transition-colors"><i class="fa-solid fa-angle-right mr-1"></i> Login Guru & Admin</a></li>
                    </ul>
                </div>

            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between text-xs font-medium text-slate-500">
                <p>© {{ date('Y') }} SMA Negeri 1 Kupang Timur. All rights reserved.</p>
                <p class="mt-2 sm:mt-0">Developed for <span class="text-slate-300 font-bold">SMAN 1 Kupang Timur</span></p>
            </div>
        </div>
    </footer>

</body>
</html>
