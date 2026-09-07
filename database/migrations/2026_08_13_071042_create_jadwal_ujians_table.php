<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_ujians', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
    $table->string('kelas', 20);
    $table->date('tanggal');
    $table->integer('durasi');
    $table->string('token', 10);
    $table->enum('status', ['belum_mulai', 'berlangsung', 'selesai'])->default('belum_mulai');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_ujians');
    }
};
