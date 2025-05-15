<?php

namespace App\Models\Admin;

use App\Models\Hewan;
use App\Models\Antrian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_hewan',
        'id_dokter',
        'deskripsi',
        'tanggal',
        'id_antrian', // Tambahkan ini
    ];

    // Definisikan relasi dengan model Hewan
    public function hewan()
    {
        return $this->belongsTo(Hewan::class, 'id_hewan');
    }

    // Definisikan relasi dengan model Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function antrian()
    {
        return $this->belongsTo(Antrian::class, 'id_antrian');
    }
}
