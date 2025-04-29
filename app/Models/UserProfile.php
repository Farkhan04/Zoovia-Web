<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    // Jika kamu pakai Laravel default timestamp (created_at & updated_at)
    public $timestamps = true;

    // Kolom yang boleh diisi massal (fillable)
    protected $fillable = [
        'user_id',
        'no_hp',
        'photo',
        'address',
    ];

    /**
     * Relasi ke model User (Many to One)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
