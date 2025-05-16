<?php

namespace App\Http\Controllers\Mobile\Layanan;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{


    public function show(Request $request, $id)
    {
        if ($request->expectsJson()) {
            try {
                $layanan = Layanan::with('dokters')->findOrFail($id);
                
                return response()->json([
                    'success' => true,
                    'data' => $layanan,
                    'message' => 'Detail layanan berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak ditemukan atau terjadi kesalahan.',
                    'error' => $e->getMessage(),
                ], 404);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Format yang diminta tidak valid.',
        ], 400);
    }

    /**
     * Menampilkan daftar layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $layanan = Layanan::with('dokters')->get(); // Mengambil semua data layanan
                return response()->json([
                    'success' => true,
                    'data' => $layanan,
                    'message' => 'Daftar layanan berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data layanan.',
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
     * Menambahkan layanan baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'nama_layanan' => 'required|string|max:255',
                'harga_layanan' => 'required|string',
                'deskripsi_layanan' => 'required|string',
                'foto_layanan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto layanan
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                // Menangani upload foto layanan jika ada
                if ($request->hasFile('foto_layanan')) {
                    $fotoPath = $request->file('foto_layanan')->store('layanan_photos', 'public');
                    $fotoUrl = "storage/".$fotoPath;
                } else {
                    $fotoUrl = null;
                }

                // Menyimpan data layanan baru
                $layanan = Layanan::create([
                    'nama_layanan' => $request->nama_layanan,
                    'harga_layanan' => $request->harga_layanan,
                    'deskripsi_layanan' => $request->deskripsi_layanan,
                    'foto_layanan' => $fotoUrl, // Menyimpan path foto
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $layanan,
                    'message' => 'Layanan berhasil ditambahkan.',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data layanan.',
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
     * Mengupdate data layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->expectsJson()) {
            // Validasi data input
            $validator = Validator::make($request->all(), [
                'nama_layanan' => 'nullable|string|max:255',
                'harga_layanan' => 'nullable|string',
                'deskripsi_layanan' => 'nullable|string',
                'foto_layanan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                // Mencari layanan berdasarkan ID
                $layanan = Layanan::findOrFail($id);

                // Mengambil data yang tervalidasi
                $validatedData = $validator->validated(); // Hanya data yang valid

                // Filter data yang tidak null (hanya yang ada pada request yang akan diupdate)
                $dataToUpdate = array_filter($validatedData);

                // Menangani upload foto baru jika ada
                if ($request->hasFile('foto_layanan')) {
                    // Menghapus foto lama jika ada
                    if ($layanan->foto_layanan && Storage::exists('public/' . $layanan->foto_layanan)) {
                        Storage::delete('public/' . $layanan->foto_layanan);
                    }

                    // Menyimpan foto baru
                    $fotoPath = $request->file('foto_layanan')->store('layanan_photos', 'public');
                    $fotoUrl = "storage/".$fotoPath;
                    $dataToUpdate['foto_layanan'] = $fotoUrl; // Update path foto
                }

                // Update data layanan dengan data yang sudah difilter
                $layanan->update($dataToUpdate);

                return response()->json([
                    'success' => true,
                    'message' => 'Layanan berhasil diperbarui.',
                    'data' => $layanan,
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak ditemukan atau terjadi kesalahan.',
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
     * Menghapus data layanan.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (request()->expectsJson()) {
            try {
                // Mencari layanan berdasarkan ID
                $layanan = Layanan::findOrFail($id);

                // Menghapus foto layanan jika ada
                if ($layanan->foto_layanan && Storage::exists('public/' . $layanan->foto_layanan)) {
                    Storage::delete('public/' . $layanan->foto_layanan);
                }

                // Menghapus data layanan
                $layanan->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Layanan berhasil dihapus.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak ditemukan atau terjadi kesalahan.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Format yang diminta tidak valid.',
        ], 400);
    }
}
