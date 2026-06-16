<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            if (!Schema::hasColumn('warungs', 'nama')) {
                $table->string('nama')->nullable();
            }
            if (!Schema::hasColumn('warungs', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
            if (!Schema::hasColumn('warungs', 'rating')) {
                $table->decimal('rating', 2, 1)->default(0);
            }
            if (!Schema::hasColumn('warungs', 'status')) {
                $table->enum('status', ['buka', 'tutup'])->default('tutup');
            }
            if (!Schema::hasColumn('warungs', 'kategori')) {
                $table->enum('kategori', ['makanan', 'minuman', 'snack'])->default('makanan');
            }
            if (!Schema::hasColumn('warungs', 'estimasi_waktu')) {
                $table->string('estimasi_waktu')->nullable();
            }
            if (!Schema::hasColumn('warungs', 'foto')) {
                $table->string('foto')->nullable();
            }
            if (!Schema::hasColumn('warungs', 'diverifikasi_pada')) {
                $table->timestamp('diverifikasi_pada')->nullable();
            }
        });
    }

    public function down(): void
    {
        //
    }
};