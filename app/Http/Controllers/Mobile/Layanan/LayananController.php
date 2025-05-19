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
}
