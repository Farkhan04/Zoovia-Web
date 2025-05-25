<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('admin.login');  // Kembali ke view login
    }

    // Menangani login pengguna
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah kredensial cocok
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika login berhasil, alihkan ke halaman yang dimaksud (misalnya dashboard)
            return redirect()->intended('/dashboard');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password anda salah.',
            'password' => 'Email atau password anda salah.',
        ]);
    }

    // Logout pengguna
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}