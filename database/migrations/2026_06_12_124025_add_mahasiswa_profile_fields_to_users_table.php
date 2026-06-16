<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // [PERUBAHAN] Menambahkan data profil mahasiswa ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto')->nullable();
            $table->string('nim')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('kontak')->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'foto',
                'nim',
                'fakultas',
                'prodi',
                'angkatan',
                'kontak',
                'alamat',
            ]);
        });
    }
};