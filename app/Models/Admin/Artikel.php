<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'judul', 'deskripsi', 'penulis', 'tanggal', 'thumbnail'
    ];
}
