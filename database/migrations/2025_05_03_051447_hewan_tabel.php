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
        Schema::create('hewan', function(Blueprint $tabelHewan){
            $tabelHewan->id(); // ID unik untuk hewan
            $tabelHewan->string('foto_hewan')->nullable();
            $tabelHewan->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $tabelHewan->string('nama_hewan'); // Nama hewan
            $tabelHewan->string('jenis_hewan'); // Jenis hewan
            $tabelHewan->string('ras')->nullable();
            $tabelHewan->integer('umur'); // Umur hewan dalam angka (integer)
            $tabelHewan->timestamps(); // Timestamp untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hewan'); // Menghapus tabel hewan
    }
};
