<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Nilai - {{ $selectedJadwal->judul }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 15mm 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 70px;
            height: auto;
        }

        .kop-text {
            flex: 1;
            text-align: center;
            padding: 0 10px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text h3 {
            margin: 3px 0;
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0 0;
            font-size: 9pt;
            font-style: italic;
        }

        /* Tabel Informasi Ujian */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10pt;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 2px;
            vertical-align: top;
        }

        /* Tabel Data Nilai */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Area Tanda Tangan */
        .signature-container {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        /* Media Print Control */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Cetak Manual -->
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4f46e5; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
            <i class="fa-solid fa-print"></i> Cetak Dokumen
        </button>
    </div>

    <!-- Kop Surat Sekolah -->
    <div class="kop-surat">
        <img src="{{ asset('images/TUTWURI.png') }}" alt="Logo Tut Wuri" class="kop-logo">
        <div class="kop-text">
            <h2>PEMERINTAH PROVINSI NUSA TENGGARA TIMUR</h2>
            <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
            <h3>SMAN 1 KUPANG TIMUR</h3>
            <p>Jln. Timor Raya Km. 29, Oesao, Kec. Kupang Timur, Kab. Kupang, NTT</p>
        </div>
        <div style="width: 70px;"></div> <!-- Spacer Penyeimbang Alignment -->
    </div>

    <!-- Judul Laporan -->
    <div style="text-align: center; margin-bottom: 20px;">
        <span style="font-size: 12pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">
            LAPORAN REKAPITULASI NILAI UJIAN
        </span>
    </div>

    <!-- Details Ujian -->
    <table class="info-table">
        <tr>
            <td width="18%"><strong>Judul Ujian</strong></td>
            <td width="2%">:</td>
            <td width="35%">{{ $selectedJadwal->judul }}</td>
            <td width="18%"><strong>Kelas Filter</strong></td>
            <td width="2%">:</td>
            <td>{{ $selectedKelas ? 'Kelas ' . $selectedKelas : 'Semua Kelas' }}</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td>{{ $selectedJadwal->mataPelajaran->nama ?? $selectedJadwal->mataPelajaran->name ?? '-' }}</td>
            <td><strong>Jurusan Filter</strong></td>
            <td>:</td>
            <td>{{ $selectedJurusan ? $selectedJurusan : 'Semua Jurusan' }}</td>
        </tr>
        <tr>
            <td><strong>Durasi Ujian</strong></td>
            <td>:</td>
            <td>{{ $selectedJadwal->durasi }} Menit</td>
            <td><strong>Total Peserta</strong></td>
            <td>:</td>
            <td>{{ $hasilUjians->count() }} Siswa</td>
        </tr>
    </table>

    <!-- Tabel Nilai -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="30%">NAMA SISWA</th>
                <th width="15%">NISN / USERNAME</th>
                <th width="10%">KELAS</th>
                <th width="12%">JURUSAN</th>
                <th width="9%">BENAR</th>
                <th width="9%">SALAH</th>
                <th width="10%">NILAI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilUjians as $hasil)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $hasil->nama_siswa }}</td>
                <td class="text-center">{{ $hasil->nisn }}</td>
                <td class="text-center">{{ $hasil->kelas ?? '-' }}</td>
                <td class="text-center">{{ $hasil->jurusan ?? '-' }}</td>
                <td class="text-center">{{ $hasil->jumlah_benar }}</td>
                <td class="text-center">{{ $hasil->jumlah_salah }}</td>
                <td class="text-center font-bold">{{ number_format($hasil->nilai, 1) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px;">Tidak ditemukan data hasil ujian sesuai kriteria filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Blok Tanda Tangan -->
    <div class="signature-container">
        <div class="signature-box">
            <p>Oesao, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Sekolah / Panitia Ujian,</p>
            <div style="height: 60px;"></div>
            <p class="font-bold" style="text-decoration: underline;">( ___________________________ )</p>
            <p style="font-size: 9pt; margin-top: 2px;">NIP. .....................................</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
