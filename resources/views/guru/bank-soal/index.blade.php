<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ showModalTambah: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal Saya - SMAN 1 Kupang Timur</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-custom { font-family: 'Libre Baskerville', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar Guru (Biru-Putih) -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col hidden md:flex flex-none shadow-2xl z-20">
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/50">
            <div class="bg-white p-1.5 rounded-xl mr-3 shadow-sm flex-none">
                <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo" class="h-8 w-8 object-contain">
            </div>
            <div class="overflow-hidden">
                <h1 class="font-bold text-xs text-white leading-snug font-serif-custom uppercase truncate">SMAN 1 KUPANG TIMUR</h1>
                <p class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase mt-0.5">PANEL GURU</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
            <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-house w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Dashboard
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">KELOLA EVALUASI</div>

            <a href="{{ route('guru.bank-soal.index') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-xl text-white font-semibold shadow-lg shadow-blue-900/30 transition-all">
                <i class="fa-solid fa-database w-6 text-center text-blue-200 mr-2"></i> Bank Soal Saya
            </a>

            <a href="{{ route('guru.jadwal-ujian.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-calendar-alt w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Jadwal Ujian
            </a>

            <a href="{{ route('guru.monitoring.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-desktop w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Monitoring Realtime
            </a>

            <div class="px-4 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-widest">LAPORAN & NILAI</div>

            <a href="{{ route('guru.rekap-nilai.index') }}" class="flex items-center px-4 py-3 hover:bg-slate-800 rounded-xl text-slate-300 font-medium transition-all group">
                <i class="fa-solid fa-chart-line w-6 text-center text-slate-500 group-hover:text-blue-400 mr-2"></i> Rekap Nilai Siswa
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-red-500/10 hover:text-red-400 rounded-xl text-slate-400 font-bold transition-all text-left group">
                    <i class="fa-solid fa-power-off w-6 text-center group-hover:text-red-400 mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Body -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-8 shadow-sm z-10 flex-none">
            <div class="text-xs font-bold text-blue-700 bg-blue-50 px-4 py-2 rounded-full flex items-center border border-blue-100">
                <i class="fa-solid fa-book-bookmark text-blue-600 mr-2"></i> Mapel: {{ $mapelGuru->nama ?? $mapelGuru->name ?? 'Belum Diatur' }}
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</span>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto space-y-6">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 font-serif-custom">Bank Soal Saya</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Kelola koleksi butir soal pilihan ganda untuk ujian Anda.</p>
                    </div>
                    <button @click="showModalTambah = true" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-blue-200 transition flex items-center">
                        <i class="fa-solid fa-plus mr-2"></i> Buat Soal Baru
                    </button>
                </div>

                @if(session('success'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-5 py-4 rounded-2xl text-sm font-semibold flex items-center">
                    <i class="fa-solid fa-check mr-3 text-blue-600"></i> {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm font-semibold">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Bar Pencarian -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <form method="GET" action="{{ route('guru.bank-soal.index') }}" class="w-full sm:w-80">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari pertanyaan soal..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-blue-500">
                    </form>
                </div>

                <!-- Tabel Soal -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-slate-200/80">
                                <tr>
                                    <th class="p-5 text-center w-12">No</th>
                                    <th class="p-5">Pertanyaan Soal</th>
                                    <th class="p-5 text-center">Kunci</th>
                                    <th class="p-5 text-right pr-6 w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                                @forelse($soals as $index => $soal)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-5 text-center font-bold text-slate-400">
                                        {{ $soals->firstItem() + $index }}
                                    </td>
                                    <td class="p-5 font-semibold text-slate-800 max-w-lg truncate">
                                        {{ $soal->pertanyaan }}
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="inline-block w-8 h-8 leading-8 bg-blue-100 text-blue-800 font-extrabold rounded-lg border border-blue-200">
                                            {{ $soal->kunci_jawaban }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-right pr-6">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="openEditModal({{ json_encode($soal) }})" class="p-2 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-lg transition" title="Edit Soal">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <form action="{{ route('guru.bank-soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white rounded-lg transition" title="Hapus Soal">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-400 font-semibold">
                                        Belum ada soal untuk mata pelajaran Anda.
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

    <!-- MODAL TAMBAH SOAL GURU -->
    <div x-show="showModalTambah" x-cloak class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl p-6 max-w-2xl w-full shadow-2xl border border-slate-100 my-8">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Tambah Soal Baru</h3>
                <button @click="showModalTambah = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form action="{{ route('guru.bank-soal.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pertanyaan Soal</label>
                    <textarea name="pertanyaan" rows="3" required placeholder="Tuliskan isi pertanyaan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi A</label>
                        <input type="text" name="opsi_a" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi B</label>
                        <input type="text" name="opsi_b" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi C</label>
                        <input type="text" name="opsi_c" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi D</label>
                        <input type="text" name="opsi_d" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi E (Opsional)</label>
                        <input type="text" name="opsi_e" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kunci Jawaban</label>
                        <select name="kunci_jawaban" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:border-blue-500">
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                            <option value="E">Opsi E</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showModalTambah = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT SOAL GURU -->
    <div id="modalEditSoal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto hidden">
        <div class="bg-white rounded-3xl p-6 max-w-2xl w-full shadow-2xl border border-slate-100 my-8">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Edit Soal</h3>
                <button onclick="document.getElementById('modalEditSoal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form id="formEditSoal" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pertanyaan Soal</label>
                    <textarea id="edit_pertanyaan" name="pertanyaan" rows="3" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi A</label>
                        <input type="text" id="edit_opsi_a" name="opsi_a" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi B</label>
                        <input type="text" id="edit_opsi_b" name="opsi_b" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi C</label>
                        <input type="text" id="edit_opsi_c" name="opsi_c" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi D</label>
                        <input type="text" id="edit_opsi_d" name="opsi_d" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Opsi E (Opsional)</label>
                        <input type="text" id="edit_opsi_e" name="opsi_e" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kunci Jawaban</label>
                        <select id="edit_kunci_jawaban" name="kunci_jawaban" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:border-blue-500">
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                            <option value="E">Opsi E</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalEditSoal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(soal) {
            document.getElementById('formEditSoal').action = '/guru/bank-soal/' + soal.id;
            document.getElementById('edit_pertanyaan').value = soal.pertanyaan;
            document.getElementById('edit_opsi_a').value = soal.opsi_a;
            document.getElementById('edit_opsi_b').value = soal.opsi_b;
            document.getElementById('edit_opsi_c').value = soal.opsi_c;
            document.getElementById('edit_opsi_d').value = soal.opsi_d;
            document.getElementById('edit_opsi_e').value = soal.opsi_e ?? '';
            document.getElementById('edit_kunci_jawaban').value = soal.kunci_jawaban;
            document.getElementById('modalEditSoal').classList.remove('hidden');
        }
    </script>
</body>
</html>
