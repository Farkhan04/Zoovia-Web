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
        Schema::create('dokter', function (Blueprint $tabelDokter) {
            $tabelDokter->id(); // ID unik untuk dokter
            $tabelDokter->string('nama_dokter'); // Nama dokter
            $tabelDokter->string('alamat'); // Spesialisasi dokter
            $tabelDokter->string('no_telepon')->nullable(); // Nomor telepon dokter
            $tabelDokter->timestamps(); // Timestamp untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
