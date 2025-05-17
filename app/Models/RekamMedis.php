<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural konvensi
    protected $table = 'rekam_medis';

    // Tentukan kolom-kolom yang dapat diisi (Mass Assignment)
    protected $fillable = [
        'id_hewan',
        'id_dokter',
        'deskripsi',
        'tanggal',
    ];

    /**
     * Relasi ke model Hewan.
     */
    public function hewan()
    {
        return $this->belongsTo(Hewan::class, 'id_hewan');
    }

    /**
     * Relasi ke model Dokter.
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

}
