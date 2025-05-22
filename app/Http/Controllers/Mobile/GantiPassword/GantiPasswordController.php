<?php
namespace App\Http\Controllers\Mobile\GantiPassword;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mobile\VerifikasiOTP\EmailVerifikasi as VerifikasiOTPEmailVerifikasi;
use App\Jobs\SendOtpEmailJob;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GantiPasswordController extends Controller
{
    function gantiPassword(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email', 'password' => 'required|string|min:6|confirmed']);
        $user = User::where('email', $request->email)->first();
        if ($request->expectsJson()) {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Email atau password dibutuhkan',
                ]);
            }

            if ($user == null) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Email tidak ditemukan',
                ]);
            }

            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'password' => $request->password,
            ]);
        }
    }

    // Fungsi untuk mengirimkan OTP untuk reset password
    public function forgotPassword(Request $request)
    {
        try {
            // Validate the email input
            $validator = Validator::make($request->all(), ['email' => 'required|email']);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Email dibutuhkan',
                ]);
            }

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            if ($user == null) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Email tidak terdaftar',
                ]);
            }

            // Generate OTP code
            $otpCode = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            // Save OTP to database
            OtpCode::updateOrCreate(
                ['user_id' => $user->id, 'type' => 'password_reset'],
                [
                    'code' => $otpCode,
                    'expired_at' => now()->addMinutes(5),
                    'used_at' => null
                ]
            );

            // Dispatch the job to send the OTP email
            SendOtpEmailJob::dispatch($user, $otpCode);

            // Respond with a success message
            return response()->json([
                'status' => 'success',
                'message' => 'Kode OTP untuk reset password telah dikirim ke email Anda',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    // Fungsi untuk verifikasi OTP dalam proses reset password
    function verifyResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Email tidak terdaftar'
            ], 400);
        }

        $otpRecord = OtpCode::where('user_id', $user->id)
            ->where('code', $request->otp)
            ->where('type', 'password_reset')
            ->where('expired_at', '>', now())
            ->whereNull('used_at')
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'status' => 'fail',
                'message' => 'OTP tidak valid atau kadaluarsa'
            ], 400);
        }

        // Tandai OTP sebagai digunakan
        $otpRecord->update(['used_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Verifikasi OTP berhasil'
        ], 200);
    }

    // Fungsi untuk reset password setelah verifikasi OTP
    function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Email tidak terdaftar',
            ], 400);
        }

        // Update password
        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah',
        ]);
    }
}