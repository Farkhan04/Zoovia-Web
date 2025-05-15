<?php

namespace App\Http\Controllers\Mobile\Logout;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController
{

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
}