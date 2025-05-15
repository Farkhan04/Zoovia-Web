<?php

namespace App\Http\Controllers\Mobile\Hewanku;

use App\Http\Controllers\Controller;
use App\Models\Hewan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HewankuController extends Controller
{

    /**
     * Mengambil semua data hewan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                // Mengambil semua data hewan dengan relasi user
                $hewan = Hewan::with('users')->get();

                return response()->json([
                    'success' => true,
                    'data' => $hewan,
                    'message' => 'Semua data hewan berhasil diambil.',
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data hewan.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Format yang diminta tidak valid.',
        ], 400);
    }

    /**
     * Menambahkan data hewan baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Mengecek apakah request mengharapkan format JSON
        if ($request->expectsJson()) {
            // Validasi data input
            $validator = Validator::make($request->all(), [
                'id_user' => 'required|exists:users,id', // Pastikan id_user ada dalam tabel users
                'nama_hewan' => 'required|string|max:15',
                'jenis_hewan' => 'required|string|max:255',
                'ras' => 'required|string|max:255',
                'umur' => 'required|integer|min:0',
                'foto_hewan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto hewan jika ada
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422); // Status 422 Unprocessable Entity
            }

            try {
                // Menangani upload foto hewan jika ada
                if ($request->hasFile('foto_hewan')) {
                    // Simpan foto hewan di folder public
                    $fotoPath = $request->file('foto_hewan')->store('hewan_photos', 'public');
                    $fotoUrl = "storage/" . $fotoPath;
                } else {
                    $fotoUrl = null; // Jika tidak ada foto, simpan null
                }

                // Menyimpan data hewan ke database
                $hewan = Hewan::create([
                    'id_user' => $request->id_user,
                    'nama_hewan' => ucwords(strtolower($request->nama_hewan)),
                    'jenis_hewan' => $request->jenis_hewan,
                    'ras' => $request->ras,
                    'umur' => $request->umur,
                    'foto_hewan' => $fotoUrl,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Hewan berhasil ditambahkan.',
                    'data' => $hewan,
                ], 201); // Status 201 Created

            } catch (Exception $e) {
                // Penanganan error jika terjadi kesalahan pada saat penyimpanan
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Terjadi kesalahan saat menambahkan hewan.',
                    'error' => $e->getMessage(),
                ], 500); // Status 500 Internal Server Error
            }
        }

        // Jika request tidak mengharapkan format JSON
        return response()->json([
            'status' => 'fail',
            'message' => 'Format yang diminta tidak valid.',
        ], 400); // Status 400 Bad Request
    }

    /**
     * Mengambil semua data hewan yang dimiliki oleh pengguna tertentu.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUserId($id_user, Request $request)
    {
        if ($request->expectsJson()) {
            try {
                // Mengambil data hewan yang dimiliki oleh pengguna tertentu
                $hewan = Hewan::where('id_user', $id_user)
                    ->with('user') // Memastikan data pengguna yang terkait juga diambil
                    ->get();

                if ($hewan->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data hewan ditemukan untuk pengguna dengan ID ' . $id_user,
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $hewan,
                    'message' => 'Data hewan untuk pengguna berhasil diambil.',
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data hewan.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Format yang diminta tidak valid.',
        ], 400);
    }

    /**
     * Mengedit data hewan berdasarkan ID, hanya update kolom yang dikirimkan.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            if ($request->expectsJson()) {
                // Menemukan data hewan berdasarkan ID
                $hewan = Hewan::findOrFail($id);

                // Validasi hanya kolom yang diperlukan
                $validator = Validator::make($request->all(), [
                    'nama_hewan' => 'nullable|string|max:255', // nama_hewan boleh kosong
                    'jenis_hewan' => 'nullable|string|max:255', // jenis_hewan boleh kosong
                    'ras' => 'nullable|string|max:255',  // ras boleh kosong
                    'umur' => 'nullable|integer|min:0',   // umur boleh kosong, dan harus integer positif jika ada
                    'foto_hewan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto hewan jika ada
                ]);

                // Cek jika validasi gagal
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Validasi gagal.',
                        'errors' => $validator->errors(),
                    ], 422); // Status 422 Unprocessable Entity
                }

                // Ambil data yang tervalidasi
                $validatedData = $validator->validated();
                Log::info('Request Data: ', $request->all());
                // Menangani upload foto baru jika ada
                if ($request->hasFile('foto_hewan')) {
                    // Menghapus foto lama jika ada
                    if ($hewan->foto_hewan && Storage::exists('public/' . $hewan->foto_hewan)) {
                        Storage::delete('public/' . $hewan->foto_hewan);
                    }

                    // Menyimpan foto baru
                    $fotoPath = $request->file('foto_hewan')->store('hewan_photos', 'public');
                    $fotoUrl = "storage/" . $fotoPath;
                    $validatedData['foto_hewan'] = $fotoUrl; // Update path foto
                }

                // Update data hanya dengan kolom yang disertakan
                $hewan->update($validatedData);

                // Mengembalikan response JSON setelah data berhasil diperbarui
                return response()->json([
                    'status' => 'success',
                    'message' => 'Hewan berhasil diperbarui.',
                    'data' => $hewan
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Hanya untuk application/json',
                ], 404);
            }

        } catch (ValidationException $e) {
            // Menangani kesalahan validasi
            return response()->json([
                'status' => 'fail',
                'message' => 'Data yang Anda kirim tidak valid.',
                'errors' => $e->errors()
            ], 422); // Status 422: Data tidak valid

        } catch (Exception $e) {
            // Menangani kesalahan lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan, coba lagi nanti.',
                'error' => $e->getMessage()
            ], 500); // Status 500: Kesalahan internal server
        }
    }

}
