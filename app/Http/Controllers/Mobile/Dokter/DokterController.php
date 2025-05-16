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

    /**
     * Menambahkan dokter baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'nama_dokter' => 'required|string|max:255',
                'id_layanan' => 'required|exists:layanan,id', // Pastikan id_layanan ada di tabel layanan
                'foto_dokter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto jika ada
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                // Menangani upload foto dokter
                if ($request->hasFile('foto_dokter')) {
                    $fotoPath = $request->file('foto_dokter')->store('dokter_photos', 'public');
                    $fotoUrl = "storage/" . $fotoPath;
                } else {
                    $fotoUrl = null; // Jika tidak ada foto, maka null
                }

                // Menyimpan data dokter baru
                $dokter = Dokter::create([
                    'nama_dokter' => $request->nama_dokter,
                    'id_layanan' => $request->id_layanan,
                    'foto_dokter' => $fotoUrl, // Menyimpan path foto
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $dokter,
                    'message' => 'Dokter berhasil ditambahkan.',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data dokter.',
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
     * Mengupdate data dokter.
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
                'nama_dokter' => 'nullable|string|max:255',
                'id_layanan' => 'nullable|exists:layanan,id',
                'foto_dokter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
                // Mencari dokter berdasarkan ID
                $dokter = Dokter::findOrFail($id);

                // Mengambil data yang tervalidasi
                $validatedData = $validator->validated(); // Hanya data yang valid

                // Filter data yang tidak null (hanya yang ada pada request yang akan diupdate)
                $dataToUpdate = array_filter($validatedData);

                // Menangani upload foto baru jika ada
                if ($request->hasFile('foto_dokter')) {
                    // Menghapus foto lama jika ada
                    if ($dokter->foto_dokter && Storage::exists('public/' . $dokter->foto_dokter)) {
                        Storage::delete('public/' . $dokter->foto_dokter);
                    }

                    // Menyimpan foto baru
                    $fotoPath = $request->file('foto_dokter')->store('dokter_photos', 'public');
                    $fotoUrl = "storage/" . $fotoPath;
                    $dataToUpdate['foto_dokter'] = $fotoUrl; // Update path foto
                }

                // Update data dokter dengan data yang sudah difilter
                $dokter->update($dataToUpdate);

                return response()->json([
                    'success' => true,
                    'message' => 'Dokter berhasil diperbarui.',
                    'data' => $dokter,
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokter tidak ditemukan atau terjadi kesalahan.',
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
     * Menghapus data dokter.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (request()->expectsJson()) {
            try {
                // Mencari dokter berdasarkan ID
                $dokter = Dokter::findOrFail($id);

                // Menghapus foto dokter jika ada
                if ($dokter->foto_dokter && Storage::exists('public/' . $dokter->foto_dokter)) {
                    Storage::delete('public/' . $dokter->foto_dokter);
                }

                // Menghapus data dokter
                $dokter->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Dokter berhasil dihapus.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokter tidak ditemukan atau terjadi kesalahan.',
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
