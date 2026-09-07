<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Portal SMAN 1 Kupang Timur</title>

    <!-- Font Klasik: Libre Baskerville & Plus Jakarta Sans untuk UI -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Kustom CSS untuk Font Libre Baskerville -->
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Menggunakan Libre Baskerville khusus untuk Judul/Heading */
        .font-serif-custom {
            font-family: 'Libre Baskerville', serif;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</head>
<body class="text-gray-900 antialiased overflow-hidden min-h-screen bg-slate-50 relative flex items-center justify-center">

    <!-- Latar Belakang Dekoratif (Animated Blobs) -->
    <div class="absolute inset-0 w-full h-full bg-blue-900 z-0 overflow-hidden">
        <!-- Lingkaran 1 -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <!-- Lingkaran 2 -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <!-- Lingkaran 3 -->
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Kontainer Form (Glassmorphism) -->
    <div class="relative z-10 w-full max-w-md px-6">
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-8 sm:p-10 border border-white/20">

            <!-- Header: Logo di Kiri, Teks di Kanan -->
            <div class="flex items-center mb-8 border-b border-gray-200/60 pb-5">
                <!-- Logo Tut Wuri Handayani -->
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo Tut Wuri Handayani" class="w-16 h-16 object-contain mr-4 drop-shadow-md">

                <!-- Teks Portal menggunakan Libre Baskerville -->
                <div class="text-left">
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight leading-none font-serif-custom">Portal Ujian</h2>
                    <p class="text-xs text-gray-500 mt-1.5 font-semibold uppercase tracking-wider">SMAN 1 Kupang Timur</p>
                </div>
            </div>

            <!-- Notifikasi Error/Session -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input Username -->
                <div class="relative">
                    <label for="username" class="block font-bold text-xs text-gray-500 uppercase tracking-wide mb-2">Username (NIS/NIP)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input id="username" class="block w-full pl-10 pr-3 py-3 border-0 bg-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors text-sm font-bold text-gray-900" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Masukkan NIS/NIP" />
                    </div>
                    <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Input Password dengan Ikon Mata (Show/Hide) -->
                <div class="mt-5 relative">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block font-bold text-xs text-gray-500 uppercase tracking-wide">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-blue-600 hover:text-blue-500 transition" href="{{ route('password.request') }}">
                                Lupa Sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <!-- Icon Gembok di Kiri -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>

                        <!-- Input Password -->
                        <input id="password" class="block w-full pl-10 pr-10 py-3 border-0 bg-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors text-sm font-bold text-gray-900" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

                        <!-- Tombol / Ikon Mata di Kanan -->
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <!-- Ikon Mata Terbuka (Default Hidden) -->
                            <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <!-- Ikon Mata Tertutup (Default Show) -->
                            <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                </div>

                <!-- Checkbox Ingat Saya -->
                <div class="block mt-6">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center w-5 h-5">
                            <input id="remember_me" type="checkbox" class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 checked:bg-blue-600 checked:border-blue-600 transition-all cursor-pointer" name="remember">
                            <svg class="absolute w-3 h-3 text-white opacity-0 peer-checked:opacity-100 pointer-events-none" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="ms-3 text-sm text-gray-600 font-bold group-hover:text-gray-900 transition-colors">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                        Masuk Portal
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tautan Kembali -->
        <div class="mt-8 text-center">
            <a href="/" class="text-sm text-blue-100 hover:text-white font-bold transition flex justify-center items-center backdrop-blur-sm bg-black/10 py-2.5 px-5 rounded-full inline-flex mx-auto border border-white/10 hover:bg-black/20">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Script JavaScript untuk Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
