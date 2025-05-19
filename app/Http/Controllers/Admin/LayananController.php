<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $layanans = Layanan::latest()->get();
        return view('admin.layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|string',
            'deskripsi_layanan' => 'required|string',
            'foto_layanan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jam_operasional_mulai' => 'required|date_format:H:i',
            'jam_operasional_selesai' => 'required|date_format:H:i|after:jam_operasional_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $layanan = new Layanan();
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga_layanan = $request->harga_layanan;
        $layanan->deskripsi_layanan = $request->deskripsi_layanan;
        $layanan->jam_operasional_mulai = $request->jam_operasional_mulai;
        $layanan->jam_operasional_selesai = $request->jam_operasional_selesai;

        if ($request->hasFile('foto_layanan')) {
            $file = $request->file('foto_layanan');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke disk 'public' langsung
            Storage::disk('public')->putFileAs('layanan_photos', $file, $filename);

            // Simpan path relatif terhadap disk 'public'
            $layanan->foto_layanan = 'layanan_photos/' . $filename;
        }

        $layanan->save();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|string',
            'deskripsi_layanan' => 'required|string',
            'foto_layanan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jam_operasional_mulai' => 'required|date_format:H:i',
            'jam_operasional_selesai' => 'required|date_format:H:i|after:jam_operasional_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $layanan = Layanan::findOrFail($id);
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->harga_layanan = $request->harga_layanan;
        $layanan->deskripsi_layanan = $request->deskripsi_layanan;
        $layanan->jam_operasional_mulai = $request->jam_operasional_mulai;
        $layanan->jam_operasional_selesai = $request->jam_operasional_selesai;

        if ($request->hasFile('foto_layanan')) {
            // Hapus foto lama jika ada
            if ($layanan->foto_layanan) {
                Storage::disk('public')->delete($layanan->foto_layanan);
            }

            $file = $request->file('foto_layanan');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke disk 'public' langsung
            Storage::disk('public')->putFileAs('layanan_photos', $file, $filename);

            // Simpan path relatif terhadap disk 'public'
            $layanan->foto_layanan = 'layanan_photos/' . $filename;
        }

        $layanan->save();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Data layanan berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        // Hapus foto jika ada
        if ($layanan->foto_layanan) {
            Storage::disk('public')->delete($layanan->foto_layanan);
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}