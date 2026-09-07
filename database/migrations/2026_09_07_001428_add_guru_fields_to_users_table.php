<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->unique()->after('id');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('name');
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->after('role');
            $table->string('foto_profil')->nullable()->after('status_akun');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'jenis_kelamin', 'status_akun', 'foto_profil']);
        });
    }
};
