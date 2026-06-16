<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::table('warungs', function (Blueprint $table) {
        $table->string('area_kampus')->nullable();
        $table->string('alamat')->nullable();
        $table->string('kontak')->nullable();
        $table->time('jam_buka')->nullable();
        $table->time('jam_tutup')->nullable();
    });
}

    public function down(): void
    {
    Schema::table('warungs', function (Blueprint $table) {
        $table->dropColumn(['area_kampus', 'alamat', 'kontak', 'jam_buka', 'jam_tutup']);
    });
    }
};
