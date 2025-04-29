<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $table = 'otp_codes';

    protected $fillable = [
        'user_id', 'code', 'type', 'expired_at', 'used_at'
    ];

    protected $dates = [
        'expired_at', 'used_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk mengecek status OTP
    public function isExpired()
    {
        return now()->gt($this->expired_at);
    }

    public function isUsed()
    {
        return !is_null($this->used_at);
    }
}
