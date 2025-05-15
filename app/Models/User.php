<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'no_hp',
        'password',
        'google_id',
        'role',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke OTP Codes
    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class);
    }

    public function antrians()
    {
        return $this->hasMany(Antrian::class, 'id_user');
    }

    // Relasi ke Profile
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    
}
