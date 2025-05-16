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
        'status',
        'nomor_antrian',  // Tambahkan ini
        'tanggal_antrian' // Tambahkan ini
    ];

    // Tambahkan metode boot() di sini
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Set tanggal_antrian ke hari ini jika belum diisi
            if (!$model->tanggal_antrian) {
                $model->tanggal_antrian = now()->toDateString();
            }
            
            // Juga bisa sekalian mengatur nomor antrian secara otomatis jika diperlukan
            if (!$model->nomor_antrian) {
                $model->nomor_antrian = self::getNextQueueNumber();
            }
        });
    }

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

    // Method to get the next queue number for today
    public static function getNextQueueNumber()
    {
        $today = now()->toDateString();
        $maxNumber = self::where('tanggal_antrian', $today)
            ->max('nomor_antrian');

        return ($maxNumber ?? 0) + 1;
    }

    // Get current active queue (being processed)
    public static function getCurrentQueue()
    {
        $today = now()->toDateString();
        return self::where('tanggal_antrian', $today)
            ->where('status', 'diproses')
            ->orderBy('nomor_antrian')
            ->first();
    }

    // Get queue summary for today
    public static function getTodayQueueSummary()
    {
        $today = now()->toDateString();

        return [
            'total' => self::where('tanggal_antrian', $today)->count(),
            'waiting' => self::where('tanggal_antrian', $today)->where('status', 'menunggu')->count(),
            'processing' => self::where('tanggal_antrian', $today)->where('status', 'diproses')->count(),
            'completed' => self::where('tanggal_antrian', $today)->where('status', 'selesai')->count(),
            'current_number' => self::getCurrentQueue()?->nomor_antrian ?? 0,
            'next_number' => self::where('tanggal_antrian', $today)
                ->where('status', 'menunggu')
                ->orderBy('nomor_antrian')
                ->first()?->nomor_antrian ?? 0,
        ];
    }
}