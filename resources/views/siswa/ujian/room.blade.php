<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Ujian - SMAN 1 Kupang Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col select-none">

    <!-- Topbar Ujian -->
    <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center shadow-sm sticky top-0 z-40">
        <div>
            <h1 class="font-extrabold text-lg text-slate-800 uppercase tracking-wide">{{ $jadwal->mataPelajaran->nama ?? $jadwal->mataPelajaran->name ?? 'Ujian Online' }}</h1>
            <p class="text-xs text-slate-500 font-bold">Peserta: {{ auth()->user()->name }} ({{ auth()->user()->username }})</p>
        </div>

        <!-- Timer Sisa Waktu -->
        <div class="bg-amber-50 border border-amber-200 px-5 py-2.5 rounded-xl flex items-center text-amber-800 font-extrabold text-lg shadow-sm">
            <i class="fa-regular fa-clock mr-2.5 text-amber-600 animate-pulse"></i>
            <span id="countdown">Memuat...</span>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto p-6 grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- Area Soal (Kiri) -->
        <div class="lg:col-span-3 bg-white rounded-3xl p-8 border border-slate-200/60 shadow-sm relative min-h-[60vh] flex flex-col justify-between">

            <form id="form-ujian" action="#" method="POST" class="flex-1">
                @foreach($soals as $index => $soal)
                <!-- Container per soal, disembunyikan kecuali soal pertama (index 0) -->
                <div id="soal-container-{{ $index }}" class="soal-wrapper {{ $index !== 0 ? 'hidden' : '' }}">

                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <span class="bg-blue-50 text-blue-600 font-extrabold text-sm px-4 py-2 rounded-xl border border-blue-100 shadow-sm">
                            Soal No. {{ $index + 1 }}
                        </span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest border border-slate-200 px-3 py-1 rounded-lg">Pilihan Ganda</span>
                    </div>

                    <!-- Teks Pertanyaan -->
                    <div class="text-slate-800 font-medium text-lg mb-8 leading-relaxed prose max-w-none">
                        {!! $soal->pertanyaan !!}
                    </div>

                    <!-- Opsi Jawaban Dinamis -->
                    <div class="space-y-3 mb-16">
                        @php
                            $opsiArray = [
                                'a' => $soal->opsi_a,
                                'b' => $soal->opsi_b,
                                'c' => $soal->opsi_c,
                                'd' => $soal->opsi_d,
                                'e' => $soal->opsi_e,
                            ];
                        @endphp

                        @foreach($opsiArray as $key => $opsiText)
                            @if(!empty($opsiText))
                            <label class="flex items-center p-4 rounded-2xl border-2 border-slate-100 hover:bg-blue-50/50 hover:border-blue-300 cursor-pointer transition-all">
                                <!-- Input Radio dengan fungsi Auto-Save AJAX -->
                                <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $key }}"
                                    onchange="saveAnswerAjax({{ $index }}, {{ $soal->id }}, '{{ $key }}')"
                                    class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">

                                <span class="ml-4 font-semibold text-base text-slate-700 flex-1">
                                    <span class="uppercase font-bold mr-2">{{ $key }}.</span> {{ $opsiText }}
                                </span>
                            </label>
                            @endif
                        @endforeach
                    </div>

                </div>
                @endforeach
            </form>

            <!-- Navigasi Bawah (Tombol Prev & Next) -->
            <div class="pt-6 border-t border-slate-100 bg-white flex justify-between items-center">
                <button type="button" onclick="prevQuestion()" id="btn-prev" class="px-6 py-3 rounded-xl border-2 border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Sebelumnya
                </button>
                <div id="save-indicator" class="text-xs font-bold text-emerald-500 opacity-0 transition-opacity">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Tersimpan
                </div>
                <button type="button" onclick="nextQuestion()" id="btn-next" class="px-8 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-200 transition flex items-center">
                    Selanjutnya <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

        <!-- Panel Navigasi Nomor Soal (Kanan) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm h-fit sticky top-28">
            <h3 class="font-extrabold text-slate-800 mb-4 text-sm uppercase tracking-wider flex items-center justify-between">
                Navigasi Soal
                <span class="bg-slate-100 text-slate-500 px-2 py-1 rounded-md text-xs">{{ count($soals) }} Soal</span>
            </h3>

            <!-- Grid Nomor Soal -->
            <div class="grid grid-cols-5 gap-2.5">
                @foreach($soals as $index => $soal)
                    <button type="button" id="nav-btn-{{ $index }}" onclick="jumpToQuestion({{ $index }})"
                            class="h-11 rounded-xl bg-slate-100 text-slate-600 font-extrabold text-sm flex items-center justify-center hover:bg-slate-200 transition border-2 border-transparent">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <button type="button" onclick="confirmFinish()" class="w-full py-3.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-extrabold text-sm uppercase tracking-widest rounded-xl transition flex justify-center items-center">
                    <i class="fa-solid fa-flag-checkered mr-2"></i> Selesai Ujian
                </button>
            </div>
        </div>

    </main>

    <!-- Modal Warning / Locked Anti-Cheat -->
    <div id="anticheat-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full text-center shadow-2xl border border-rose-100">
            <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 animate-bounce">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 id="anticheat-title" class="text-xl font-bold text-slate-800 mb-2">Peringatan Kecurangan!</h3>
            <p id="anticheat-message" class="text-xs text-slate-600 font-medium leading-relaxed mb-6"></p>

            <button id="anticheat-btn" type="button" onclick="closeAntiCheatModal()" class="w-full py-3 bg-rose-600 hover:bg-rose-700 active:scale-95 text-white font-bold rounded-2xl text-xs shadow-lg shadow-rose-200 transition">
                Saya Mengerti & Kembali Ujian
            </button>
        </div>
    </div>

    <!-- Form Tersembunyi untuk Submit Akhir -->
    <form id="form-finish-ujian" action="{{ route('siswa.ujian.selesai', $jadwal->id) }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Script JavaScript Inti Ujian & Anti-Cheat -->
    <script>
        const totalQuestions = {{ count($soals) }};
        const jadwalUjianId = {{ $jadwal->id }};
        const durasiUjianMenit = {{ $jadwal->durasi ?? 90 }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentIndex = 0;

        // Anti-Cheat Flags
        let isExamLocked = false;
        let isProcessingViolation = false;

        // Data Jawaban dari Database (Jika halaman di-refresh)
        const existingAnswers = @json($jawabanSiswa ?? []);

        document.addEventListener("DOMContentLoaded", function() {
            // Restorasi Jawaban Terpilih
            Object.keys(existingAnswers).forEach(soalId => {
                const val = existingAnswers[soalId];
                const inputRadio = document.querySelector(`input[name="jawaban[${soalId}]"][value="${val}"]`);
                if (inputRadio) {
                    inputRadio.checked = true;
                    const container = inputRadio.closest('.soal-wrapper');
                    if (container) {
                        const index = container.id.replace('soal-container-', '');
                        markAnsweredUI(index);
                    }
                }
            });

            updateUI();
            startTimer();
            initAntiCheat();
        });

        // -----------------------------------------------------------------
        // Anti-Cheat Logic (Page Visibility & Window Blur Event Listener)
        // -----------------------------------------------------------------
        function initAntiCheat() {
            // Deteksi ketika siswa pindah tab / minimize browser
            document.addEventListener('visibilitychange', function() {
                if (document.hidden && !isExamLocked) {
                    recordViolation();
                }
            });

            // Deteksi ketika kursor keluar dari jendela browser
            window.addEventListener('blur', function() {
                if (!isExamLocked) {
                    recordViolation();
                }
            });
        }

        function recordViolation() {
            if (isExamLocked || isProcessingViolation) return;
            isProcessingViolation = true;

            fetch('{{ route("siswa.ujian.catat-pelanggaran") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    jadwal_id: jadwalUjianId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    showAntiCheatModal(data.message, data.is_locked);

                    if (data.is_locked) {
                        isExamLocked = true;
                        localStorage.removeItem('exam_end_time_' + jadwalUjianId);
                        setTimeout(() => {
                            document.getElementById('form-finish-ujian').submit();
                        }, 3000);
                    }
                }
            })
            .catch(error => {
                console.error('Error recording violation:', error);
            })
            .finally(() => {
                setTimeout(() => { isProcessingViolation = false; }, 1500);
            });
        }

        function showAntiCheatModal(msg, isLocked) {
            const modal = document.getElementById('anticheat-modal');
            const title = document.getElementById('anticheat-title');
            const message = document.getElementById('anticheat-message');
            const btn = document.getElementById('anticheat-btn');

            message.innerText = msg;
            modal.classList.remove('hidden');

            if (isLocked) {
                title.innerText = 'Ujian Terkunci!';
                btn.innerText = 'Mengumpulkan Jawaban...';
                btn.onclick = null;
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                title.innerText = 'Peringatan Pelanggaran!';
                btn.innerText = 'Saya Mengerti & Kembali Ujian';
                btn.onclick = closeAntiCheatModal;
            }
        }

        function closeAntiCheatModal() {
            document.getElementById('anticheat-modal').classList.add('hidden');
        }

        // -----------------------------------------------------------------
        // Navigasi Soal
        // -----------------------------------------------------------------
        function nextQuestion() {
            if (currentIndex < totalQuestions - 1) {
                document.getElementById('soal-container-' + currentIndex).classList.add('hidden');
                currentIndex++;
                document.getElementById('soal-container-' + currentIndex).classList.remove('hidden');
                updateUI();
            }
        }

        function prevQuestion() {
            if (currentIndex > 0) {
                document.getElementById('soal-container-' + currentIndex).classList.add('hidden');
                currentIndex--;
                document.getElementById('soal-container-' + currentIndex).classList.remove('hidden');
                updateUI();
            }
        }

        function jumpToQuestion(index) {
            document.getElementById('soal-container-' + currentIndex).classList.add('hidden');
            currentIndex = index;
            document.getElementById('soal-container-' + currentIndex).classList.remove('hidden');
            updateUI();
        }

        function updateUI() {
            document.getElementById('btn-prev').disabled = (currentIndex === 0);

            if (currentIndex === totalQuestions - 1) {
                document.getElementById('btn-next').classList.add('hidden');
            } else {
                document.getElementById('btn-next').classList.remove('hidden');
            }

            // Indikator Posisi Soal Aktif
            for (let i = 0; i < totalQuestions; i++) {
                let navBtn = document.getElementById('nav-btn-' + i);
                if (i === currentIndex) {
                    navBtn.classList.add('ring-2', 'ring-offset-2', 'ring-blue-600');
                } else {
                    navBtn.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-600');
                }
            }
        }

        // Auto Save AJAX & Warna Biru Navigasi Soal Terisi
        function saveAnswerAjax(index, soalId, jawabanVal) {
            markAnsweredUI(index);

            const indicator = document.getElementById('save-indicator');
            indicator.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Menyimpan...';
            indicator.classList.remove('opacity-0', 'text-emerald-500', 'text-rose-500');
            indicator.classList.add('text-amber-500');

            fetch('{{ route("siswa.ujian.simpan-jawaban") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    jadwal_ujian_id: jadwalUjianId,
                    soal_id: soalId,
                    jawaban: jawabanVal
                })
            })
            .then(response => response.json())
            .then(data => {
                indicator.innerHTML = '<i class="fa-solid fa-cloud-arrow-up mr-1"></i> Tersimpan';
                indicator.classList.remove('text-amber-500');
                indicator.classList.add('text-emerald-500');

                setTimeout(() => { indicator.classList.add('opacity-0'); }, 2000);
            })
            .catch(error => {
                console.error('Error auto-saving:', error);
                indicator.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1"></i> Gagal Simpan';
                indicator.classList.remove('text-amber-500');
                indicator.classList.add('text-rose-500');
            });
        }

        // Mengubah warna tombol navigasi menjadi Biru saat soal sudah diisi
        function markAnsweredUI(index) {
            let navBtn = document.getElementById('nav-btn-' + index);
            if (navBtn) {
                navBtn.classList.remove('bg-slate-100', 'text-slate-600', 'hover:bg-slate-200');
                navBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'shadow-md', 'shadow-blue-200');
            }
        }

        // Timer & Selesai Ujian
        function confirmFinish() {
            if(confirm('Apakah Anda yakin ingin menyelesaikan ujian? Anda tidak bisa mengubah jawaban setelah ini.')) {
                localStorage.removeItem('exam_end_time_' + jadwalUjianId);
                document.getElementById('form-finish-ujian').submit();
            }
        }

        function startTimer() {
            let endTime = localStorage.getItem('exam_end_time_' + jadwalUjianId);
            if (!endTime) {
                let now = new Date();
                now.setMinutes(now.getMinutes() + durasiUjianMenit);
                endTime = now.getTime();
                localStorage.setItem('exam_end_time_' + jadwalUjianId, endTime);
            }

            let timerInterval = setInterval(function() {
                let now = new Date().getTime();
                let distance = endTime - now;

                if (distance <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('countdown').innerHTML = "WAKTU HABIS";
                    localStorage.removeItem('exam_end_time_' + jadwalUjianId);
                    alert('Waktu ujian telah habis! Jawaban Anda akan dikumpulkan otomatis.');
                    document.getElementById('form-finish-ujian').submit();
                    return;
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                hours = (hours < 10) ? "0" + hours : hours;
                minutes = (minutes < 10) ? "0" + minutes : minutes;
                seconds = (seconds < 10) ? "0" + seconds : seconds;

                document.getElementById('countdown').innerHTML = hours + ":" + minutes + ":" + seconds;
            }, 1000);
        }
    </script>
</body>
</html>
