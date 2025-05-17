<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::with('layanan')->latest()->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanans = Layanan::all();
        return view('admin.dokter.create', compact('layanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dokter' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'id_layanan' => 'required|exists:layanan,id',
            'foto_dokter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dokter = new Dokter();
        $dokter->nama_dokter = $request->nama_dokter;
        $dokter->alamat = $request->alamat;
        $dokter->no_telepon = $request->no_telepon;
        $dokter->id_layanan = $request->id_layanan;

        if ($request->hasFile('foto_dokter')) {
            $file = $request->file('foto_dokter');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/dokter', $filename);
            $dokter->foto_dokter = 'dokter/' . $filename;
        }

        $dokter->save();

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Dokter berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokter = Dokter::with('layanan')->findOrFail($id);
        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);
        $layanans = Layanan::all();
        return view('admin.dokter.edit', compact('dokter', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_dokter' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'id_layanan' => 'required|exists:layanan,id',
            'foto_dokter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dokter = Dokter::findOrFail($id);
        $dokter->nama_dokter = $request->nama_dokter;
        $dokter->alamat = $request->alamat;
        $dokter->no_telepon = $request->no_telepon;
        $dokter->id_layanan = $request->id_layanan;

        if ($request->hasFile('foto_dokter')) {
            // Hapus foto lama jika ada
            if ($dokter->foto_dokter) {
                Storage::delete('public/' . $dokter->foto_dokter);
            }
            
            $file = $request->file('foto_dokter');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/dokter', $filename);
            $dokter->foto_dokter = 'dokter/' . $filename;
        }

        $dokter->save();

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        
        // Hapus foto jika ada
        if ($dokter->foto_dokter) {
            Storage::delete('public/' . $dokter->foto_dokter);
        }
        
        $dokter->delete();

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Dokter berhasil dihapus!');
    }
}