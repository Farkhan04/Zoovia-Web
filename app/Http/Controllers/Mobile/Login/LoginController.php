<?php

namespace App\Http\Controllers\Mobile\Login;

use App\Models\OtpCode;
use App\Models\User;
use Exception;
use Google_Client;
use Google_Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController
{

    public function login(Request $request)
    {
        // Handle Mobile Request
        if ($request->expectsJson()) {
            return $this->handleMobileLogin($request);
        }

        // Handle Web Request
        return $this->handleWebLogin($request);
    }

    protected function handleMobileLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validasi gagal'
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kredensial tidak valid'
                ], 401);
            }

            if (!$user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun belum diverifikasi'
                ], 403);
            }

            if ($user->role !== 'user') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses hanya untuk pengguna mobile'
                ], 403);
            }

            // Generate Sanctum token
            $token = $user->createToken('mobile-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'message' => 'Login Berhasil!',
                    'user' => $user->only('id','name', 'email',),
                    'token' => $token, // Token Sanctum
                ],
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function handleWebLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->email_verified_at) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun belum diverifikasi']);
            }

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akses hanya untuk admin']);
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan password tidak valid',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        try {
            // Handle Mobile Logout (Token Based)
            if ($request->expectsJson()) {
                $request->user()->tokens()->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Logout berhasil'
                ]);
            }

            // Handle Web Logout (Session Based)
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('message', 'Logout berhasil');

        } catch (Exception $e) {
            // Handle error untuk kedua platform
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat logout',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect('/login')->withErrors([
                'error' => 'Terjadi kesalahan saat logout'
            ]);
        }
    }

    public function loginWithGoogle(Request $request)
    {

        $request->validate([
            'google_token' => 'required|string',
        ]);

        try {
            if (empty($request->google_token)) {
                return response()->json(['error' => 'Empty Google token'], 400);
            }

            $client = new Google_Client([
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'verify_token' => true,
                'required_claims' => ['iss', 'sub', 'email', 'exp']
            ]);

            try {
                $payload = $client->verifyIdToken($request->google_token);

                if ($payload === false) {
                    return response()->json(['error' => 'Invalid Google token'], 401);
                }

                // buat atau cari user dengan email yang sama
                $user = User::firstOrCreate(
                    ['google_id' => $payload['sub']],
                    [
                        'email' => $payload['email'],
                        'email_verified_at' => now(),
                    ]
                );

                // Buat API Token untuk Mobile
                $token = $user->createToken('mobile-token')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'nama' => $user->name
                ]);

            } catch (Google_Exception $googleException) {
                Log::error('Google Token Verification Exception', [
                    'message' => $googleException->getMessage(),
                    'trace' => $googleException->getTraceAsString()
                ]);
                return response()->json([
                    'error' => 'Google token verification failed',
                    'message' => $googleException->getMessage()
                ], 401);
            }

        } catch (Exception $e) {
            Log::error('Authentication Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}