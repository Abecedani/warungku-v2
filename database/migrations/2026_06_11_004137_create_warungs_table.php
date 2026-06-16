<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('warungs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->enum('status', ['buka', 'tutup'])->default('buka');
            $table->string('estimasi_waktu')->nullable();
            $table->enum('kategori', ['makanan', 'minuman', 'snack'])->default('makanan');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('warungs');
    }
};
