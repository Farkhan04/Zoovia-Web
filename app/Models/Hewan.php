<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan konvensi Laravel (opsional)
    protected $table = 'hewan';

    // Tentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'id_user',    // ID pengguna yang memiliki hewan
        'foto_hewan',
        'nama_hewan', // Nama hewan
        'jenis_hewan',// Jenis hewan
        'ras',        // Ras hewan
        'umur',       // Umur hewan
    ];

    // Tentukan relasi dengan tabel 'users' (relasi ke tabel pengguna)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // Relasi ke model User
    }

    // Menambahkan aksesori atau mutator untuk data yang ingin ditampilkan atau diubah jika diperlukan
}
