<?php

namespace App\Http\Controllers\Mobile\Register;

use App\Http\Controllers\Mobile\VerifikasiOTP\EmailVerifikasi;
use App\Models\OtpCode;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|unique:users,no_hp',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($request->expectsJson()){
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors(),
                        'message' => 'Validasi gagal'
                    ], 422);
                }
    
                $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_hp' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);
    
                OtpCode::create([
                    'user_id' => $user->id,
                    'code' => $otp,
                    'type' => 'email',
                    'expired_at' => now()->addMinutes(15),
                    'used_at' => null,
                ]);
    
                Mail::to($user->email)->send(new EmailVerifikasi($otp, $user->name));
    
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil. Silakan verifikasi dengan OTP yang dikirim ke email.',
                    'email' => $user->email,
                    'user_id' => $user->id,
                ], 201);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Hanya untuk API",
                ], 500);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}