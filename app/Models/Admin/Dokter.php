<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Layanan;

class Dokter extends Model
{
        // Nama tabel yang digunakan (Laravel secara default akan mencari tabel 'dokters', tapi kamu bisa menyesuaikannya)
        protected $table = 'dokter';

        // Kolom yang bisa diisi (fillable)
        protected $fillable = [
                'nama_dokter',
                'id_layanan',
        ];

        // Relasi ke Layanan (Setiap dokter dapat memiliki satu layanan)
        public function layanan()
        {
                return $this->belongsTo(Layanan::class, 'id_layanan');
        }
}
