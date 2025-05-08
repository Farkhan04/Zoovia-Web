<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\RekamMedis;
use App\Models\Admin\Hewan;
use App\Models\Admin\Dokter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hewan as ModelsHewan;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis.
     */
    public function index()
    {
        // Ambil semua data rekam medis dengan relasi hewan dan dokter
        $rekamMedis = RekamMedis::with(['hewan', 'dokter'])->get();

        return view('Admin.RekamMedis.index', compact('rekamMedis'));
    }

    /**
     * Menampilkan form untuk membuat rekam medis baru.
     */
    public function create()
    {
        // Ambil semua data hewan dan dokter untuk dropdown
        $hewan = ModelsHewan::all();
        $dokter = Dokter::all();

        return view('admin.rekam_medis.create', compact('hewan', 'dokter'));
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

        return redirect()->route('admin.rekam_medis.index');
    }
}
