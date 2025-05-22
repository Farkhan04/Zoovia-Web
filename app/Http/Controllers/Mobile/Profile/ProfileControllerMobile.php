<?php

namespace App\Http\Controllers\Mobile\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProfileControllerMobile extends Controller
{

    // Fungsi untuk membuat profil pengguna baru
    public function createOrUpdate(Request $request)
    {
        /* 1. ── VALIDASI MANUAL (agar bisa bentuk respons sendiri) ─────────────── */
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'email' => 'nullable|email|unique:users,email,' . $request->id,
            'nama' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|unique:users,no_hp,' . $request->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5048',
            'address' => 'nullable|string|max:500',
        ], [
            'photo.max' => 'Ukuran foto maksimal 2 MB',
            'photo.image' => 'File harus berupa gambar (JPG/PNG).',
        ]);

        if ($request->expectsJson()) {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            /* 2. ── CARI USER ─────────────────────────────────────────────────────── */
            $user = User::find($request->id);
            if (!$user) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User tidak ditemukan',
                ], 404);
            }

            /* 3. ── TRANSAKSI DB + TRY/CATCH UNTUK ROLLBACK & LOG ERROR ──────────── */
            try {
                DB::beginTransaction();

                // ambil profil atau buat baru
                $profile = UserProfile::firstOrCreate(
                    ['user_id' => $user->id],
                    ['address' => $request->address]   // field default bila baru
                );

                // update atribut sederhana
                if ($request->has('address') && $request->address !== $profile->address) {
                    $profile->address = $request->address;
                }

                // Perbarui email hanya jika berbeda dari nilai yang sudah ada
                if ($request->has('email') && $request->email !== $user->email) {
                    $user->email = $request->input('email');
                }

                // Perbarui nama jika ada dan berbeda
                if ($request->has('nama') && $request->nama !== $user->name) {
                    $user->name = $request->input('nama');
                }

                // Perbarui no_hp hanya jika berbeda dari nilai yang sudah ada
                if ($request->has('no_hp') && $request->no_hp !== $user->no_hp) {
                    $user->no_hp = $request->input('no_hp');
                }

                // handle upload foto (jika ada)
                if ($request->hasFile('photo') && $request) {
                    // hapus foto lama jika ada
                    if ($profile->photo) {
                        Storage::disk('public')->delete($profile->photo);
                    }
                    // simpan foto baru
                    $file = $request->file('photo');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    Storage::disk('public')->putFileAs('profile_photos', $file, $filename);
                    $profile->photo = 'profile_photos/'.$filename;
                }

                // Simpan perubahan hanya jika ada perubahan
                if ($user->isDirty()) {
                    $user->save();
                }

                if ($profile->isDirty()) {
                    $profile->save();
                }

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Profil berhasil diperbarui',
                    'data' => [
                        'user' => [
                            'id' => $user->id,
                            'nama' => $user->name,
                            'email' => $user->email,
                            'no_hp' => $user->no_hp,
                        ],
                        'profile' => [
                            'photo' => $profile->photo,
                            'address' => $profile->address,
                        ],
                    ],
                ], 200);

            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('[UpdateProfile] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.',
                ], 500);
            }
        }
    }
}
