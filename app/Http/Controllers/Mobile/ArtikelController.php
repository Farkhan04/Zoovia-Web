<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        if ($request->expectsJson()) {
            try {
                $artikel = Artikel::orderBy('tanggal', 'desc')->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $artikel,
                    'message' => 'Daftar artikel berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data artikel.',
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
     * Store a newly created article in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'penulis' => 'required|string|max:255',
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
                // Handle file upload if thumbnail exists
                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $request->file('thumbnail')->store('artikel_photos', 'public');
                    $thumbnailUrl = "storage/" . $thumbnailPath;
                } else {
                    $thumbnailUrl = null;
                }

                // Create new article
                $artikel = Artikel::create([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'penulis' => $request->penulis,
                    'thumbnail' => $thumbnailUrl,
                    'tanggal' => now(), // Use current timestamp
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $artikel,
                    'message' => 'Artikel berhasil disimpan.',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan artikel.',
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
     * Display the specified article.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        if ($request->expectsJson()) {
            try {
                $artikel = Artikel::findOrFail($id);
                
                return response()->json([
                    'success' => true,
                    'data' => $artikel,
                    'message' => 'Detail artikel berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan atau terjadi kesalahan.',
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
     * Update the specified article in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'judul' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'penulis' => 'nullable|string|max:255',
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
                
                // Get validated data
                $validatedData = $validator->validated();
                
                // Filter out null values
                $dataToUpdate = array_filter($validatedData, function ($value) {
                    return $value !== null;
                });
                
                // Handle thumbnail upload if exists
                if ($request->hasFile('thumbnail')) {
                    // Delete old thumbnail if exists
                    if ($artikel->thumbnail && Storage::exists('public/' . str_replace('storage/', '', $artikel->thumbnail))) {
                        Storage::delete('public/' . str_replace('storage/', '', $artikel->thumbnail));
                    }
                    
                    // Store new thumbnail
                    $thumbnailPath = $request->file('thumbnail')->store('artikel_photos', 'public');
                    $dataToUpdate['thumbnail'] = "storage/" . $thumbnailPath;
                }
                
                // Update the article
                $artikel->update($dataToUpdate);
                
                return response()->json([
                    'success' => true,
                    'data' => $artikel,
                    'message' => 'Artikel berhasil diperbarui.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan atau terjadi kesalahan.',
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
     * Remove the specified article from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($request->expectsJson()) {
            try {
                $artikel = Artikel::findOrFail($id);
                
                // Delete thumbnail if exists
                if ($artikel->thumbnail && Storage::exists('public/' . str_replace('storage/', '', $artikel->thumbnail))) {
                    Storage::delete('public/' . str_replace('storage/', '', $artikel->thumbnail));
                }
                
                // Delete article
                $artikel->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil dihapus.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan atau terjadi kesalahan.',
                    'error' => $e->getMessage(),
                ], 404);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Format yang diminta tidak valid.',
        ], 400);
    }
}