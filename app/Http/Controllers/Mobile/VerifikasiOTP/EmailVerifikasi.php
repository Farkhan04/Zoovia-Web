<?php

namespace App\Http\Controllers\Mobile\VerifikasiOTP;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerifikasi extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    public function __construct(string $otp, string $name)
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Akun Anda')
            ->markdown('emails.verify', ['otp' => $this->otp, 'name' => $this->name]);
    }
}