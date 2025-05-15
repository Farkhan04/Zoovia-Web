<?php
namespace App\Http\Controllers\Mobile\GantiPassword;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VerifikasiOTP\EmailVerifikasi;
use App\Http\Controllers\VerifikasiOTP\VerifikasiOtpController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GantiPasswordController extends Controller
{
    function gantiPassword(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email', 'password' => 'required|string|min:6|confirmed']);
        $user = User::where('email', $request->email)->first();
        if($request->expectsJson()){
            if($validator->fails()){
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Email atau password dibutuhkan',
                ]);
            }

            if($user == null){
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
}