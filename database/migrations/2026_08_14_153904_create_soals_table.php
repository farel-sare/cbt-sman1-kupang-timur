<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel mata pelajaran
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');

            // Pertanyaan soal (bisa teks panjang)
            $table->text('pertanyaan');

            // Pilihan ganda A sampai E
            $table->text('opsi_a');
            $table->text('opsi_b');
            $table->text('opsi_c');
            $table->text('opsi_d');
            $table->text('opsi_e')->nullable(); // Opsional jika hanya 4 pilihan

            // Kunci jawaban (a, b, c, d, atau e)
            $table->char('kunci_jawaban', 1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
