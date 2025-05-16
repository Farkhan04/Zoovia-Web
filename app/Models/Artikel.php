<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // Set table name explicitly (in case you're not following Laravel naming conventions)
    protected $table = 'artikel';

    // Define fillable fields
    protected $fillable = [
        'thumbnail',
        'judul',
        'deskripsi',
        'penulis',
        'tanggal',
    ];

    // Cast fields to specific types
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // Accessor to get a default thumbnail if none exists
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return $this->thumbnail;
        }
        
        // Return a default placeholder image URL
        return 'storage/artikel_photos/default.jpg';
    }
}