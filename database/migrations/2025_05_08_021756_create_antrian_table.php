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
        Schema::create('antrian', function (Blueprint $tabelAntrian) {
            $tabelAntrian->id();
            $tabelAntrian->string('nama');
            $tabelAntrian->text('keluhan');
            $tabelAntrian->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $tabelAntrian->foreignId('id_layanan')->constrained('layanan')->onDelete('cascade');
            $tabelAntrian->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $tabelAntrian->foreignId('id_hewan')->constrained('hewan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};
