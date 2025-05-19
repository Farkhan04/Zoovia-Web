<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ArtikelController extends Controller
{
    /**
     * Display a listing of articles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->expectsJson()) {
            return $this->invalidFormatResponse();
        }
        
        try {
            $artikel = Artikel::orderBy('tanggal', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $artikel,
                'message' => 'Daftar artikel berhasil diambil.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            return $this->errorResponse('Terjadi kesalahan saat mengambil data artikel.', $e->getMessage());
        }
    }
    
    /**
     * Display the specified article.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        if (!$request->expectsJson()) {
            return $this->invalidFormatResponse();
        }
        
        try {
            $artikel = Artikel::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $artikel,
                'message' => 'Detail artikel berhasil diambil.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching article details: ' . $e->getMessage());
            return $this->errorResponse('Artikel tidak ditemukan atau terjadi kesalahan.', $e->getMessage(), 404);
        }
    }

    /**
     * Return invalid format response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function invalidFormatResponse()
    {
        return response()->json([
            'success' => false,
            'message' => 'Format yang diminta tidak valid.',
        ], 400);
    }
    
    /**
     * Return error response.
     *
     * @param string $message
     * @param string $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse($message, $error, $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], $code);
    }
}