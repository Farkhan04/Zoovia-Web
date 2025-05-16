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
     * Store a newly created article in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!$request->expectsJson()) {
            return $this->invalidFormatResponse();
        }
        
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Upload thumbnail if exists
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $this->uploadThumbnail($request->file('thumbnail'));
            }

            // Create new article
            $artikel = Artikel::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'penulis' => $request->penulis,
                'tanggal' => $request->input('tanggal', now()),
                'thumbnail' => $thumbnailPath,
            ]);

            return response()->json([
                'success' => true,
                'data' => $artikel,
                'message' => 'Artikel berhasil disimpan.',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return $this->errorResponse('Terjadi kesalahan saat menyimpan artikel.', $e->getMessage());
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
     * Update the specified article in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!$request->expectsJson()) {
            return $this->invalidFormatResponse();
        }
        
        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'penulis' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Find the article by ID
            $artikel = Artikel::findOrFail($id);
            
            // Handle thumbnail upload if exists
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                $this->deleteThumbnail($artikel->thumbnail);
                
                // Upload new thumbnail
                $thumbnailPath = $this->uploadThumbnail($request->file('thumbnail'));
                $artikel->thumbnail = $thumbnailPath;
            }
            
            // Update other fields if provided
            if ($request->has('judul')) {
                $artikel->judul = $request->judul;
            }
            if ($request->has('deskripsi')) {
                $artikel->deskripsi = $request->deskripsi;
            }
            if ($request->has('penulis')) {
                $artikel->penulis = $request->penulis;
            }
            if ($request->has('tanggal')) {
                $artikel->tanggal = $request->tanggal;
            }
            
            // Save article
            $artikel->save();
            
            return response()->json([
                'success' => true,
                'data' => $artikel,
                'message' => 'Artikel berhasil diperbarui.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            return $this->errorResponse('Artikel tidak ditemukan atau terjadi kesalahan.', $e->getMessage());
        }
    }

    /**
     * Remove the specified article from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->expectsJson()) {
            return $this->invalidFormatResponse();
        }
        
        try {
            $artikel = Artikel::findOrFail($id);
            
            // Delete thumbnail if exists
            $this->deleteThumbnail($artikel->thumbnail);
            
            // Delete article
            $artikel->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            return $this->errorResponse('Artikel tidak ditemukan atau terjadi kesalahan.', $e->getMessage(), 404);
        }
    }
    
    /**
     * Upload thumbnail and return storage path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function uploadThumbnail($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'artikel_' . time() . '_' . Str::random(10) . '.' . $extension;
        $path = $file->storeAs('artikel_photos', $filename, 'public');
        return $path;
    }
    
    /**
     * Delete thumbnail from storage.
     *
     * @param string|null $path
     * @return void
     */
    private function deleteThumbnail($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
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