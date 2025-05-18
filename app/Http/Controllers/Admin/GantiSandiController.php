<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class GantiSandiController extends Controller
{
    // Fungsi untuk menampilkan halaman ganti sandi
    public function showChangePasswordForm()
    {
        return view('admin.gantisandi');
    }

    // Fungsi untuk menampilkan halaman sukses ganti password
    public function showSuccessPage()
    {
        return view('admin.password-success');
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('change.password.form')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Dapatkan user saat ini
            $user = Auth::user();

            // Periksa apakah user ditemukan
            if (!$user) {
                Log::error('User tidak ditemukan dalam session');
                return redirect()->route('change.password.form')
                    ->withErrors(['auth_error' => 'User tidak ditemukan dalam session.']);
            }

            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('change.password.form')
                    ->withErrors(['current_password' => 'Password saat ini salah.']);
            }

            // Alternative cara menyimpan password
            // Gunakan User::find() untuk memastikan kita mendapatkan instance yang benar
            $userModel = User::find($user->id);
            if (!$userModel) {
                Log::error('User model tidak ditemukan: ID=' . $user->id);
                return redirect()->route('change.password.form')
                    ->withErrors(['user_error' => 'User tidak ditemukan dalam database.']);
            }

            $userModel->password = Hash::make($request->new_password);
            $result = $userModel->save();

            // Debug untuk melihat hasil operasi save()
            if (!$result) {
                return redirect()->route('change.password.form')
                    ->withErrors(['save_error' => 'Gagal menyimpan password (save() mengembalikan false).']);
            }

            // Redirect ke halaman sukses bukannya langsung ke dashboard
            return redirect()->route('admin.password.success');
        } catch (\Exception $e) {
            // Log error detail
            Log::error('Error saat menyimpan password: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->withErrors(['save_error' => 'Terjadi kesalahan saat menyimpan password: ' . $e->getMessage()]);
        }
    }
}