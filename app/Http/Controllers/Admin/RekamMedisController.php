<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\RekamMedis;
use App\Models\Admin\Hewan;
use App\Models\Admin\Dokter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hewan as ModelsHewan;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis.
     */
    public function index(Request $request, $status = null)
    {
        $query = RekamMedis::with(['hewan', 'dokter', 'antrian']);

        // Menambahkan pencarian berdasarkan parameter "search"
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            // Filter rekam medis berdasarkan deskripsi atau kolom lainnya
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('hewan', function ($query) use ($search) {
                        $query->where('nama_hewan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('dokter', function ($query) use ($search) {
                        $query->where('nama_dokter', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter berdasarkan status antrian jika ada
        if ($status) {
            $query->whereHas('antrian', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        // Mendapatkan rekam medis yang difilter
        $rekamMedis = $query->paginate(10); // Anda bisa menyesuaikan jumlah artikel per halaman

        return view('Admin.RekamMedis.index', compact('rekamMedis'));
    }


    /**
     * Menampilkan form untuk membuat rekam medis baru.
     */
    // public function create()
    // {
    //     // Ambil semua data hewan dan dokter untuk dropdown
    //     $hewan = ModelsHewan::all();
    //     $dokter = Dokter::all();

    //     return view('admin.rekam_medis.create', compact('hewan', 'dokter'));
    // }

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

        return redirect()->route('admin.rekam_medis.index');
    }

    // public function update(Request $request, $id)
    // {
    //     // Ambil rekam medis berdasarkan ID
    //     $rekam = RekamMedis::findOrFail($id);

    //     // Validasi data yang diterima
    //     $validated = $request->validate([
    //         'deskripsi' => 'required|string',
    //         'tanggal' => 'required|date',
    //     ]);

    //     // Perbarui data rekam medis
    //     $rekam->update([
    //         'deskripsi' => $validated['deskripsi'],
    //         'tanggal' => $validated['tanggal'],
    //     ]);

    //     // Ubah status antrian menjadi 'selesai'
    //     $rekam->antrian->update(['status' => 'selesai']);

    //     // Redirect ke halaman utama dengan pesan sukses
    //     return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui dan status antrian diubah menjadi selesai.');
    // }

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

        // Ubah status antrian menjadi 'selesai'
        if ($rekam->antrian) {
            $rekam->antrian->update(['status' => 'selesai']);
        }

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui dan status antrian diubah menjadi selesai.');
    }

    // Fungsi untuk menghapus data rekam medis
    public function destroy($id)
    {
        // Cek apakah data rekam medis ada
        $medicalRecord = RekamMedis::find($id);

        // Jika data tidak ditemukan, return error
        if (!$medicalRecord) {
            return redirect()->route('admin.rekammedis.index')->with('error', 'Data Rekam Medis tidak ditemukan.');
        }

        // Hapus data rekam medis
        $medicalRecord->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.rekammedis.index')->with('success', 'Data Rekam Medis berhasil dihapus.');
    }
}
