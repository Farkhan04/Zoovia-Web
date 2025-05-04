<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';

    // Menentukan relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Menentukan relasi ke Hewan
    public function hewan()
    {
        return $this->belongsTo(Hewan::class, 'id_hewan');
    }

    // Menentukan relasi ke Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}
