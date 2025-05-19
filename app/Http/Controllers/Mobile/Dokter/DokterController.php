<?php

namespace App\Http\Controllers\Mobile\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    /**
     * Menampilkan daftar dokter.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                $dokters = Dokter::with('layanan')->get(); // Mengambil semua data dokter dengan relasi layanan
                return response()->json([
                    'success' => true,
                    'data' => $dokters,
                    'message' => 'Daftar dokter berhasil diambil.',
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

    public function getByLayananId(Request $request, $layananId)
    {
        if ($request->expectsJson()) {
            try {
                $dokters = Dokter::with('layanan')
                    ->where('id_layanan', $layananId)
                    ->get();

                return response()->json([
                    'success' => true,
                    'data' => $dokters,
                    'message' => 'Daftar dokter untuk layanan berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data dokter.',
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
