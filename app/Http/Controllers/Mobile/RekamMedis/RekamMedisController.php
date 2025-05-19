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
     * Menampilkan detail rekam medis berdasarkan ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        if ($request->expectsJson()) {
            try {
                $rekamMedis = RekamMedis::with(['hewan', 'dokter.layanan'])
                    ->findOrFail($id);

                return response()->json([
                    'success' => true,
                    'data' => $rekamMedis,
                    'message' => 'Detail rekam medis berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rekam medis tidak ditemukan atau terjadi kesalahan.',
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
     * Menampilkan daftar rekam medis berdasarkan ID hewan.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $hewanId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByHewanId(Request $request, $hewanId)
    {
        if ($request->expectsJson()) {
            try {
                $rekamMedis = RekamMedis::with(['hewan', 'dokter.layanan'])
                    ->where('id_hewan', $hewanId)
                    ->orderBy('created_at', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'data' => $rekamMedis,
                    'message' => 'Rekam medis berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil rekam medis.',
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
