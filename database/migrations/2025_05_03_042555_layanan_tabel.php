<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $tableLayanan) {
            $tableLayanan->id(); // ID unik untuk layanan
            $tableLayanan->string('foto_layanan')->nullable();
            $tableLayanan->string('nama_layanan'); // Nama layanan
            $tableLayanan->string('harga_layanan'); // Harga layanan
            $tableLayanan->text('deskripsi_layanan'); // Deskripsi layanan (seharusnya tipe text, bukan integer)
            $tableLayanan->time('jam_operasional_mulai')->default('08:00');
            $tableLayanan->time('jam_operasional_selesai')->default('17:00');
            $tableLayanan->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
