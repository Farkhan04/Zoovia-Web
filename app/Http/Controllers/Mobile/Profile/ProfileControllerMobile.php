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
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'nama' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|unique:users,no_hp|max:16',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5048',
            'address' => 'nullable|string|max:500',
        ], [
            'photo.max' => 'Ukuran foto maksimal 2 MB',               // ← pesan kustom
            'photo.image' => 'File harus berupa gambar (JPG/PNG).',
        ]);

        if ($request->expectsJson()) {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),   // detail field yang gagal
                ], 422);
            }

            /* 2. ── CARI USER ─────────────────────────────────────────────────────── */
            $user = User::find($request->id)->first();
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
                $profile->fill($request->only(['address']));

                if ($request->has('email')) {
                    $user->email = $request->input('email');
                }

                if ($request->has('nama')) {
                    $user->name = $request->input('nama');
                }

                if ($request->has('no_hp')) {
                    $user->no_hp = $request->input('no_hp');
                }

                // handle upload foto (jika ada)
                if ($request->hasFile('photo')) {
                    // hapus foto lama jika ada
                    if ($profile->photo) {
                        Storage::delete($profile->photo);
                    }
                    // simpan foto baru
                    $urlToSaveToDB = $request->file('photo')->store('profile_photos');
                    $profile->photo = 'http://192.168.214.220:7071/' . $urlToSaveToDB;
                }

                $user->save();
                $profile->save();
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

    public function getProfilePhoto($filename)
    {
        $path = storage_path("app/private/profile_photos/{$filename}");

        if (!Storage::exists("private/profile_photos/{$filename}") || !file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);
        $mimeType = mime_content_type($path);

        return response($file, Response::HTTP_OK)
            ->header('Content-Type', $mimeType);
    }
}
