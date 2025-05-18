<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dokter; // Corrected namespace
use App\Models\Layanan;

class DokterController extends Controller
{

    // Menampilkan daftar dokter
    public function index()
    {
        $dokters = Dokter::paginate(10);  // Adjust the number to your desired pagination size
        return view('dokter.index', compact('dokters'));
    }

    // Menampilkan form untuk menambah dokter baru
    public function create()
    {
        return view('dokter.create');
    }

    // Menyimpan dokter baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'foto_dokter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_layanan' => 'nullable|exists:layanan,id',
        ]);

        $dokter = new Dokter;
        $dokter->nama_dokter = $request->nama_dokter;
        $dokter->alamat = $request->alamat;
        $dokter->no_telepon = $request->no_telepon;
        $dokter->id_layanan = $request->id_layanan;

        // Menyimpan foto dokter jika ada
        if ($request->hasFile('foto_dokter')) {
            $file = $request->file('foto_dokter');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/dokters'), $fileName);
            $dokter->foto_dokter = $fileName;
        }

        $dokter->save();
        return redirect()->route('dokter.index');
    }

    // Menampilkan form untuk mengedit dokter
    public function edit(Dokter $dokter)
    {
        // Ambil data layanan
        $layanan = Layanan::all();  // Pastikan ini mengambil data layanan sesuai dengan yang Anda butuhkan
        return view('dokter.edit', compact('dokter', 'layanan'));
    }

    // Memperbarui data dokter
    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'foto_dokter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_layanan' => 'nullable|exists:layanan,id',
        ]);

        $dokter->nama_dokter = $request->nama_dokter;
        $dokter->alamat = $request->alamat;
        $dokter->no_telepon = $request->no_telepon;
        $dokter->id_layanan = $request->id_layanan;

        // Menyimpan foto dokter jika ada perubahan
        if ($request->hasFile('foto_dokter')) {
            $file = $request->file('foto_dokter');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/dokters'), $fileName);
            $dokter->foto_dokter = $fileName;
        }

        $dokter->save();
        return redirect()->route('admin.dokter.index');
    }

    // Menghapus dokter
    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index');
    }
}
