<?php
namespace App\Jobs;

use App\Http\Controllers\Mobile\VerifikasiOTP\EmailVerifikasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOtpEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $otpCode;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $otpCode
     * @return void
     */
    public function __construct($user, $otpCode)
    {
        $this->user = $user;
        $this->otpCode = $otpCode;

        Log::info('[QUEUE] Job dibuat', [
            'email' => $this->user->email,
            'otp' => $this->otpCode
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::info('[QUEUE] Job DIJALANKAN', [
                'email' => $this->user->email
            ]);

            Mail::to($this->user->email)->send(
                new EmailVerifikasi($this->otpCode, $this->user->name)
            );
        } catch (\Throwable $e) {
            Log::error('[QUEUE] Job ERROR: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
