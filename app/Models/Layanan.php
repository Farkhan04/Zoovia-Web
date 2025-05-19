<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    // Menentukan nama tabel (optional, karena sudah sesuai dengan konvensi)
    protected $table = 'layanan';

    // Kolom yang dapat diisi (fillable)
    protected $fillable = [
        'nama_layanan',
        'harga_layanan',
        'deskripsi_layanan',
        'foto_layanan',
        'jam_operasional_mulai',
        'jam_operasional_selesai',
    ];

    // Jika ingin mendefinisikan relasi, misalnya dengan model Dokter atau Antrian
    public function dokters()
    {
        return $this->hasMany(Dokter::class, 'id_layanan');
    }
}
