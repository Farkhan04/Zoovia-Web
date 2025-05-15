<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    use HasFactory;


    // Kolom yang dapat diisi
    protected $fillable = [
        'foto_hewan',
        'id_user',
        'nama_hewan',
        'jenis_hewan',
        'ras',
        'umur',
    ];

    /**
     * Relasi dengan model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');  // Menunjukkan bahwa setiap hewan dimiliki oleh user
    }
}
