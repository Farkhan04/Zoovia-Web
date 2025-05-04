<?php
namespace App\Http\Controllers\Mobile\VerifikasiOTP;


use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifikasiOtpController
{
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:4',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar'], 400);
        }

        $otpRecord = OtpCode::where('user_id', $user->id)
            ->where('code', $request->otp)
            ->where('type', 'email')
            ->where('expired_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'OTP tidak valid atau kadaluarsa'], 400);
        }

        // Tandai OTP digunakan
        $otpRecord->update(['used_at' => now()]);

        // Verifikasi email user
        $user->update(['email_verified_at' => now()]);

        return response()->json(['status' => 'success', 'message' => 'Verifikasi berhasil'], 200);
    }

    public function resend(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $user = User::firstWhere('email', $request->email, $request->email);

            if ($user == null) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User tidak ditemukan',
                ]);
            }

            $otpCode = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            OtpCode::updateOrCreate(['user_id' => $user->id], ['code' => $otpCode, 'expired_at' => now()->addMinutes(5),]);
            Mail::to($user->email)->send(new EmailVerifikasi($otpCode, $user->name));

            return response()->json([
                'status' => 'success',
                'data' => ['message' => "OTP berhasil diperbarui, silahkan cek email anda!"],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], );
        }
    }
}