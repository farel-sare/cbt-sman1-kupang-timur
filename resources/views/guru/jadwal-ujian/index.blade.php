<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ showModalTambah: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Ujian Saya - SMAN 1 Kupang Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
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
            <a href="{{ route('guru.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-900/30 transition">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-blue-200 mr-2"></i> Jadwal Ujian
            </a>
            <a href="{{ route('guru.monitoring.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition">
                <i class="fa-solid fa-desktop w-6 text-center mr-2"></i> Monitoring Realtime
            </a>
            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase">LAPORAN & NILAI</div>
            <a href="{{ route('guru.rekap-nilai.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-xl font-medium transition">
                <i class="fa-solid fa-chart-line w-6 text-center mr-2"></i> Rekap Nilai Siswa
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-xs font-bold text-blue-700 bg-blue-50 px-4 py-2 rounded-full border border-blue-100">
                <i class="fa-solid fa-calendar-days mr-2"></i> Kelola Jadwal Ujian
            </div>
            <span class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</span>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Jadwal Ujian Saya</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Atur jadwal sesi ujian CBT untuk siswa Anda.</p>
                    </div>
                    <button @click="showModalTambah = true" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition flex items-center">
                        <i class="fa-solid fa-plus mr-2"></i> Buat Jadwal Ujian
                    </button>
                </div>

                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-semibold flex items-center">
                    <i class="fa-solid fa-check mr-3 text-emerald-600"></i> {{ session('success') }}
                </div>
                @endif

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="p-4 text-center">No</th>
                                    <th class="p-4">Nama Ujian</th>
                                    <th class="p-4 text-center">Kelas Target</th>
                                    <th class="p-4 text-center">Durasi</th>
                                    <th class="p-4 text-center">Token</th>
                                    <th class="p-4 text-center">Status</th>
                                    <th class="p-4 text-right pr-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                                @forelse($jadwal_ujians as $index => $jadwal)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 text-center font-bold text-slate-400">{{ $jadwal_ujians->firstItem() + $index }}</td>
                                    <td class="p-4 font-bold text-slate-800">{{ $jadwal->nama_ujian }}</td>
                                    <td class="p-4 text-center"><span class="bg-slate-100 px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200">{{ $jadwal->kelas }}</span></td>
                                    <td class="p-4 text-center">{{ $jadwal->lama_ujian }} Menit</td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('guru.jadwal-ujian.generate-token', $jadwal->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="Klik untuk acak token" class="font-mono font-extrabold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition">
                                                {{ $jadwal->token }} <i class="fa-solid fa-arrows-rotate text-[10px] ml-1"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('guru.jadwal-ujian.toggle-status', $jadwal->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-bold transition border {{ in_array($jadwal->status, ['1', 'aktif', 'buka']) ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                                                {{ in_array($jadwal->status, ['1', 'aktif', 'buka']) ? 'Aktif / Buka' : 'Tutup' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-4 text-right pr-6">
                                        <form action="{{ route('guru.jadwal-ujian.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg transition" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="p-8 text-center text-slate-400 font-semibold">Belum ada jadwal ujian.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Jadwal Ujian -->
    <div x-show="showModalTambah" x-cloak class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-lg w-full shadow-2xl border border-slate-100">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Buat Jadwal Ujian</h3>
                <button @click="showModalTambah = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form action="{{ route('guru.jadwal-ujian.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Ujian</label>
                    <input type="text" name="nama_ujian" required placeholder="Contoh: PAS Matematika X MIPA" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kelas Target</label>
                        <input type="text" name="kelas" required placeholder="Contoh: X MIPA 1" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Durasi (Menit)</label>
                        <input type="number" name="lama_ujian" value="90" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mulai Ujian</label>
                        <input type="datetime-local" name="tgl_mulai" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Selesai Ujian</label>
                        <input type="datetime-local" name="tgl_selesai" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showModalTambah = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
