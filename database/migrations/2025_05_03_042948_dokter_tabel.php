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
        Schema::create('dokter', function(Blueprint $tableDokter){
            $tableDokter->id();
            $tableDokter->string('foto_dokter')->nullable();
            $tableDokter->string('nama_dokter');
            $tableDokter->foreignId('id_layanan')->nullable()->constrained('layanan')->onUpdate('cascade')->nullOnDelete();
            $tableDokter->timestamps();
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
