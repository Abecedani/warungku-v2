<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // [PERUBAHAN] Menambahkan informasi lokasi dan kontak warung
        Schema::table('warungs', function (Blueprint $table) {
            $table->string('kontak')->nullable();
            $table->string('area_kampus')->nullable();
            $table->text('alamat')->nullable();
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            $table->dropColumn([
                'kontak',
                'area_kampus',
                'alamat',
                'jam_buka',
                'jam_tutup',
            ]);
        });
    }
};