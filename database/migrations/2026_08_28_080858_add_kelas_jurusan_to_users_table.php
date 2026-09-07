<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('role');   // Contoh: 10, 11, 12
            $table->string('jurusan')->nullable()->after('kelas'); // Contoh: IPA, IPS, Bahasa
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kelas', 'jurusan']);
        });
    }
};
