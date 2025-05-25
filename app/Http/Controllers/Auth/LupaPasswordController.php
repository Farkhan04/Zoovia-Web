<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpEmailJob;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LupaPasswordController extends Controller
{
    public function index()
    {
        return view("Admin.lupapassword");
    }

    /**
     * Kirim OTP ke email user
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar dalam sistem'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();

            // Hapus OTP lama yang belum expired untuk user ini
            OtpCode::where('user_id', $user->id)
                ->where('type', 'password_reset')
                ->where('expired_at', '>', now())
                ->delete();

            // Generate OTP 6 digit
            $otpCode = rand(100000, 999999);

            // Simpan OTP ke database (expired dalam 10 menit)
            OtpCode::create([
                'user_id' => $user->id,
                'code' => $otpCode,
                'type' => 'password_reset',
                'expired_at' => Carbon::now()->addMinutes(10)
            ]);

            // Kirim email OTP menggunakan Job
            SendOtpEmailJob::dispatch($user, $otpCode);

            return redirect()->route('lupa.password.verify', ['email' => $request->email])
                ->with('success', 'Kode OTP telah dikirim ke email Anda. Silahkan cek email dan masukkan kode OTP.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengirim OTP. Silahkan coba lagi.');
        }
    }

    /**
     * Tampilkan form verifikasi OTP
     */
    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('lupa.password')->with('error', 'Email tidak valid');
        }

        return view('Admin.verifikasi-otp', compact('email'));
    }

    /**
     * Verifikasi OTP yang dimasukkan user
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6'
        ], [
            'email.required' => 'Email harus diisi',
            'email.exists' => 'Email tidak valid',
            'otp.required' => 'Kode OTP harus diisi',
            'otp.numeric' => 'Kode OTP harus berupa angka',
            'otp.digits' => 'Kode OTP harus 6 digit'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();

            $otpRecord = OtpCode::where('user_id', $user->id)
                ->where('code', $request->otp)
                ->where('type', 'password_reset')
                ->where('used_at', null)
                ->first();

            if (!$otpRecord) {
                return back()->with('error', 'Kode OTP tidak valid')->withInput();
            }

            if ($otpRecord->isExpired()) {
                return back()->with('error', 'Kode OTP sudah expired. Silahkan minta kode baru.')->withInput();
            }

            // Generate token untuk reset password
            $resetToken = Str::random(60);

            // Tandai OTP sebagai sudah digunakan
            $otpRecord->update(['used_at' => now()]);

            // Simpan token reset di session (atau bisa juga di database)
            session(['reset_token' => $resetToken, 'reset_email' => $request->email]);

            return redirect()->route('lupa.password.reset')
                ->with('success', 'Kode OTP berhasil diverifikasi. Silahkan masukkan password baru Anda.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat verifikasi OTP. Silahkan coba lagi.');
        }
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetForm()
    {
        if (!session('reset_token') || !session('reset_email')) {
            return redirect()->route('lupa.password')->with('error', 'Session tidak valid. Silahkan ulangi proses dari awal.');
        }

        return view('Admin.reset-password');
    }

    /**
     * Reset password user
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_token') || !session('reset_email')) {
            return redirect()->route('lupa.password')->with('error', 'Session tidak valid. Silahkan ulangi proses dari awal.');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password_confirmation.required' => 'Konfirmasi password harus diisi'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $email = session('reset_email');
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->route('lupa.password')->with('error', 'User tidak ditemukan.');
            }

            // Update password user
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Hapus semua OTP user yang masih aktif
            OtpCode::where('user_id', $user->id)
                ->where('type', 'password_reset')
                ->delete();

            // Hapus session reset
            session()->forget(['reset_token', 'reset_email']);

            return redirect()->route('login')
                ->with('success', 'Password berhasil diubah. Silahkan login dengan password baru Anda.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengubah password. Silahkan coba lagi.');
        }
    }

    /**
     * Kirim ulang OTP
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();

            // Cek apakah user sudah request OTP dalam 1 menit terakhir (rate limiting)
            $recentOtp = OtpCode::where('user_id', $user->id)
                ->where('type', 'password_reset')
                ->where('created_at', '>', Carbon::now()->subMinute())
                ->first();

            if ($recentOtp) {
                return back()->with('error', 'Mohon tunggu 1 menit sebelum meminta kode OTP baru.');
            }

            // Hapus OTP lama
            OtpCode::where('user_id', $user->id)
                ->where('type', 'password_reset')
                ->delete();

            // Generate OTP baru
            $otpCode = rand(100000, 999999);

            // Simpan OTP baru
            OtpCode::create([
                'user_id' => $user->id,
                'code' => $otpCode,
                'type' => 'password_reset',
                'expired_at' => Carbon::now()->addMinutes(10)
            ]);

            // Kirim email OTP
            SendOtpEmailJob::dispatch($user, $otpCode);

            return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengirim ulang OTP. Silahkan coba lagi.');
        }
    }
}