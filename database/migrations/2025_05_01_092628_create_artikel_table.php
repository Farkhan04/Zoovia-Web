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
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail')->nullable(); // Kolom untuk menyimpan path gambar
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('penulis');
            $table->timestamp('tanggal')->useCurrent(); // Kolom tanggal dengan nilai default saat ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
