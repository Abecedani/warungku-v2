<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            $table->unique('nama');
        });
    }

    public function down(): void
    {
        Schema::table('warungs', function (Blueprint $table) {
            $table->dropUnique(['nama']);
            $table->dropConstrainedForeignId('user_id');
        });
    }
};