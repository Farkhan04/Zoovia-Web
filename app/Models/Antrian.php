<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';

    protected $fillable = [
        'nama',
        'keluhan',
        'id_layanan',
        'id_user',
        'id_hewan',
        'status'
    ];

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

    // Helper methods untuk status
    public function isMenunggu()
    {
        return $this->status === 'menunggu';
    }

    public function isDiproses()
    {
        return $this->status === 'diproses';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    // Scope untuk memudahkan query berdasarkan status
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}