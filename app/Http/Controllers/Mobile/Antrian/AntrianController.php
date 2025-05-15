<?php

namespace App\Http\Controllers\Mobile\Antrian;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Hewan;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\AntrianUpdated;

class AntrianController extends Controller
{
    /**
     * Menampilkan daftar antrian.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                // Parameter status opsional untuk filter
                $status = $request->query('status');
                
                // Query dasar
                $query = Antrian::with(['user', 'hewan', 'layanan']);
                
                // Filter berdasarkan status jika diberikan
                if ($status && in_array($status, ['menunggu', 'diproses', 'selesai'])) {
                    $query->where('status', $status);
                }
                
                // Ambil data dan urutkan
                $antrian = $query->orderBy('created_at', 'asc')->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian,
                    'message' => 'Daftar antrian berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                Log::error('Error saat mengambil daftar antrian: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data antrian.',
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
     * Menambahkan antrian baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'keluhan' => 'required|string',
                'id_layanan' => 'required|exists:layanan,id',
                'id_user' => 'required|exists:users,id',
                'id_hewan' => 'required|exists:hewan,id',
                'status' => 'nullable|in:menunggu,diproses,selesai', // Status opsional, defaultnya adalah 'menunggu'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                DB::beginTransaction();

                // Pastikan hewan dimiliki oleh user yang terdaftar
                $hewan = Hewan::findOrFail($request->id_hewan);
                if ($hewan->id_user != $request->id_user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Hewan tidak terdaftar pada user ini.',
                    ], 403);
                }

                // Buat antrian baru dengan status default 'menunggu' jika tidak disebutkan
                $antrian = Antrian::create([
                    'nama' => $request->nama,
                    'keluhan' => $request->keluhan,
                    'id_layanan' => $request->id_layanan,
                    'id_user' => $request->id_user,
                    'id_hewan' => $request->id_hewan,
                    'status' => $request->status ?? 'menunggu',
                ]);

                DB::commit();

                // Broadcast event untuk update real-time
                Log::info('Broadcasting antrian event: ' . 'create' . ' for ID: ' . $antrian->id);
                event(new AntrianUpdated('create', $antrian->load(['user', 'hewan', 'layanan'])));

                return response()->json([
                    'success' => true,
                    'data' => $antrian->load(['user', 'hewan', 'layanan']),
                    'message' => 'Antrian berhasil ditambahkan.',
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error saat membuat antrian: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat membuat antrian.',
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
     * Menampilkan detail antrian.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        if ($request->expectsJson()) {
            try {
                $antrian = Antrian::with(['user', 'hewan', 'layanan'])->findOrFail($id);
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian,
                    'message' => 'Detail antrian berhasil diambil.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian tidak ditemukan atau terjadi kesalahan.',
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
     * Mengupdate data antrian.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'nama' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string',
                'id_layanan' => 'nullable|exists:layanan,id',
                'id_hewan' => 'nullable|exists:hewan,id',
                'status' => 'nullable|in:menunggu,diproses,selesai', // Validasi untuk status
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                DB::beginTransaction();
                
                // Cari antrian berdasarkan ID
                $antrian = Antrian::findOrFail($id);
                
                // Mengambil data yang tervalidasi
                $validatedData = $validator->validated();
                
                // Filter data yang tidak null (hanya yang ada pada request yang akan diupdate)
                $dataToUpdate = array_filter($validatedData, function ($value) {
                    return $value !== null;
                });
                
                // Jika hewan diubah, pastikan hewan dimiliki oleh user yang sama
                if (isset($dataToUpdate['id_hewan'])) {
                    $hewan = Hewan::findOrFail($dataToUpdate['id_hewan']);
                    if ($hewan->id_user != $antrian->id_user) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Hewan tidak terdaftar pada user ini.',
                        ], 403);
                    }
                }
                
                // Update data antrian
                $antrian->update($dataToUpdate);
                
                DB::commit();
                
                // Broadcast event untuk update real-time
                event(new AntrianUpdated('update', $antrian->load(['user', 'hewan', 'layanan'])));
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian->load(['user', 'hewan', 'layanan']),
                    'message' => 'Antrian berhasil diperbarui.',
                ], 200);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error saat mengupdate antrian: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian tidak ditemukan atau terjadi kesalahan.',
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
     * Mengupdate status antrian.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        if ($request->expectsJson()) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:menunggu,diproses,selesai',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                DB::beginTransaction();
                
                // Cari antrian berdasarkan ID
                $antrian = Antrian::with(['user', 'hewan', 'layanan'])->findOrFail($id);
                
                // Update status
                $antrian->status = $request->status;
                $antrian->save();
                
                DB::commit();
                
                // Broadcast event untuk update real-time
                event(new AntrianUpdated('update-status', $antrian));
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian,
                    'message' => 'Status antrian berhasil diperbarui menjadi ' . $request->status,
                ], 200);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error saat mengupdate status antrian: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian tidak ditemukan atau terjadi kesalahan.',
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
     * Menghapus data antrian.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($request->expectsJson()) {
            try {
                DB::beginTransaction();
                
                // Cari antrian berdasarkan ID
                $antrian = Antrian::with(['user', 'hewan', 'layanan'])->findOrFail($id);
                $antrianData = $antrian->toArray(); // Simpan data sebelum dihapus untuk broadcast
                
                // Hapus antrian
                $antrian->delete();
                
                DB::commit();
                
                // Broadcast event untuk update real-time
                event(new AntrianUpdated('delete', $antrianData));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Antrian berhasil dihapus.',
                ], 200);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error saat menghapus antrian: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian tidak ditemukan atau terjadi kesalahan.',
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
     * Mengambil antrian berdasarkan user ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByUserId(Request $request, $userId)
    {
        if ($request->expectsJson()) {
            try {
                // Cek apakah user ada
                $user = User::findOrFail($userId);
                
                // Parameter status opsional untuk filter
                $status = $request->query('status');
                
                // Query dasar
                $query = Antrian::with(['hewan', 'layanan'])
                               ->where('id_user', $userId);
                
                // Filter berdasarkan status jika diberikan
                if ($status && in_array($status, ['menunggu', 'diproses', 'selesai'])) {
                    $query->where('status', $status);
                }
                
                // Ambil data dan urutkan
                $antrian = $query->orderBy('created_at', 'desc')->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian,
                    'message' => 'Daftar antrian user berhasil diambil.',
                ], 200);
                
            } catch (\Exception $e) {
                Log::error('Error saat mengambil antrian user: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan atau terjadi kesalahan.',
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
     * Mengambil antrian berdasarkan layanan ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $layananId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByLayananId(Request $request, $layananId)
    {
        if ($request->expectsJson()) {
            try {
                // Cek apakah layanan ada
                $layanan = Layanan::findOrFail($layananId);
                
                // Parameter status opsional untuk filter
                $status = $request->query('status');
                
                // Query dasar
                $query = Antrian::with(['user', 'hewan'])
                               ->where('id_layanan', $layananId);
                
                // Filter berdasarkan status jika diberikan
                if ($status && in_array($status, ['menunggu', 'diproses', 'selesai'])) {
                    $query->where('status', $status);
                }
                
                // Ambil data dan urutkan
                $antrian = $query->orderBy('created_at', 'asc')->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian,
                    'message' => 'Daftar antrian untuk layanan berhasil diambil.',
                ], 200);
                
            } catch (\Exception $e) {
                Log::error('Error saat mengambil antrian layanan: ' . $e->getMessage());
                
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
     * Mengambil antrian berdasarkan status.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByStatus(Request $request, $status)
    {
        if ($request->expectsJson()) {
            if (!in_array($status, ['menunggu', 'diproses', 'selesai'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid. Gunakan: menunggu, diproses, atau selesai.',
                ], 400);
            }
            
            try {
                // Ambil antrian berdasarkan status
                $antrian = Antrian::with(['user', 'hewan', 'layanan'])
                                 ->where('status', $status)
                                 ->orderBy('created_at', 'asc')
                                 ->get();
                
                return response()->json([
                    'success' => true,
                    'data' => $antrian,
                    'message' => 'Daftar antrian dengan status ' . $status . ' berhasil diambil.',
                ], 200);
                
            } catch (\Exception $e) {
                Log::error('Error saat mengambil antrian berdasarkan status: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengambil data antrian.',
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