<?php

namespace App\Http\Controllers\Mobile\RekamMedis;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $rekamMedis = RekamMedis::with(['hewan', 'dokter'])->get(); // Mengambil semua data rekam medis dengan relasi hewan dan dokter
                return response()->json([
                    'success' => true,
                    'data' => $rekamMedis,
                    'message' => 'Daftar rekam medis berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan, coba lagi nanti.',
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
     * Menambahkan rekam medis baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'id_hewan' => 'required|exists:hewan,id', // Validasi ID hewan yang valid
                'id_dokter' => 'required|exists:dokter,id', // Validasi ID dokter yang valid
                'deskripsi' => 'required|string|max:1000', // Deskripsi yang harus diisi
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                // Menyimpan rekam medis baru
                $rekamMedis = RekamMedis::create([
                    'id_hewan' => $request->id_hewan,
                    'id_dokter' => $request->id_dokter,
                    'deskripsi' => $request->deskripsi,
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $rekamMedis,
                    'message' => 'Rekam medis berhasil ditambahkan.',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan rekam medis.',
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
     * Mengupdate data rekam medis.
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
                'id_hewan' => 'nullable|exists:hewan,id',
                'id_dokter' => 'nullable|exists:dokter,id',
                'deskripsi' => 'nullable|string|max:1000',
            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                // Mencari rekam medis berdasarkan ID
                $rekamMedis = RekamMedis::findOrFail($id);

                // Mengambil data yang tervalidasi
                $validatedData = $validator->validated(); // Hanya data yang valid

                // Filter data yang tidak null (hanya yang ada pada request yang akan diupdate)
                $dataToUpdate = array_filter($validatedData);

                // Update data rekam medis dengan data yang sudah difilter
                $rekamMedis->update($dataToUpdate);

                return response()->json([
                    'success' => true,
                    'message' => 'Rekam medis berhasil diperbarui.',
                    'data' => $rekamMedis,
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekam medis tidak ditemukan atau terjadi kesalahan.',
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
     * Menghapus data rekam medis.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (request()->expectsJson()) {
            try {
                // Mencari rekam medis berdasarkan ID
                $rekamMedis = RekamMedis::findOrFail($id);

                // Menghapus data rekam medis
                $rekamMedis->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Rekam medis berhasil dihapus.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekam medis tidak ditemukan atau terjadi kesalahan.',
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
