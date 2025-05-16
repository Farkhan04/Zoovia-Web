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
        Schema::create('rekam_medis', function (Blueprint $tabelRekamMedis) {
            $tabelRekamMedis->id();
            $tabelRekamMedis->foreignId('id_hewan')->constrained('hewan');
            $tabelRekamMedis->foreignId('id_dokter')->constrained('dokter');
            $tabelRekamMedis->foreignId('id_antrian')->constrained('antrian');
            $tabelRekamMedis->string('deskripsi');
            $tabelRekamMedis->timestamp('tanggal')->useCurrent(); // Kolom tanggal dengan nilai default saat ini
            $tabelRekamMedis->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
