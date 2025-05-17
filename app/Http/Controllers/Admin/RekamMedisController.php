<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dokter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hewan;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar hewan beserta rekam medisnya.
     */
    public function index(Request $request)
    {
        // Ambil semua hewan yang memiliki rekam medis
        $query = Hewan::whereHas('rekamMedis');

        // Filter pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_hewan', 'like', '%' . $search . '%')
                  ->orWhere('jenis_hewan', 'like', '%' . $search . '%');
            });
        }

        // Ambil hewan dengan rekam medis terbaru
        $hewans = $query->with(['rekamMedis' => function($query) {
            $query->orderBy('tanggal', 'desc');
        }, 'rekamMedis.dokter'])
        ->paginate(10);

        return view('Admin.RekamMedis.index', compact('hewans'));
    }

    /**
     * Menampilkan detail rekam medis hewan.
     */
    public function show($id)
    {
        $hewan = Hewan::findOrFail($id);
        $rekamMedis = RekamMedis::where('id_hewan', $id)
            ->with('dokter')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('Admin.RekamMedis.show', compact('hewan', 'rekamMedis'));
    }

    /**
     * Menyimpan rekam medis baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_hewan' => 'required|exists:hewan,id',
            'id_dokter' => 'required|exists:dokter,id',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Simpan rekam medis
        RekamMedis::create([
            'id_hewan' => $request->id_hewan,
            'id_dokter' => $request->id_dokter,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin.rekammedis.index')
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Memperbarui rekam medis yang ada.
     */
    public function update(Request $request, $id)
    {
        // Ambil rekam medis berdasarkan ID
        $rekam = RekamMedis::findOrFail($id);

        // Validasi data yang diterima
        $validated = $request->validate([
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Perbarui data rekam medis
        $rekam->update([
            'deskripsi' => $validated['deskripsi'],
            'tanggal' => $validated['tanggal'],
        ]);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->back()
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Menghapus rekam medis.
     */
    public function destroy($id)
    {
        // Cek apakah data rekam medis ada
        $rekamMedis = RekamMedis::find($id);

        // Jika data tidak ditemukan, return error
        if (!$rekamMedis) {
            return redirect()->back()
                ->with('error', 'Data Rekam Medis tidak ditemukan.');
        }

        // Hapus data rekam medis
        $rekamMedis->delete();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()
            ->with('success', 'Data Rekam Medis berhasil dihapus.');
    }
}