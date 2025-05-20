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
        try {
            $query = request('search');
            $filter = request('filter');

            $dokters = Dokter::with('layanan')
                ->when($query, function($q) use ($query) {
                    return $q->where('nama_dokter', 'like', '%' . $query . '%')
                             ->orWhereHas('layanan', function($q2) use ($query) {
                                 $q2->where('nama_layanan', 'like', '%' . $query . '%');
                             });
                })
                ->when($filter, function($q) use ($filter) {
                    return $q->where('id_layanan', $filter);
                })
                ->latest()
                ->get();

            if(request()->ajax()) {
                $view = view('admin.dokter.partial.table', compact('dokters'))->render();
                
                return response()->json([
                    'status' => 'success',
                    'table_data' => $view
                ]);
            }

            return view('admin.dokter.index', compact('dokters'));
            
        } catch (\Exception $e) {
            if(request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat memuat data'
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
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

            // Simpan file ke disk 'public' langsung
            Storage::disk('public')->putFileAs('dokter_photos', $file, $filename);

            // Simpan path relatif terhadap disk 'public'
            $dokter->foto_dokter = 'dokter_photos/' . $filename;
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
                Storage::disk('public')->delete($dokter->foto_dokter);
            }

            $file = $request->file('foto_dokter');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke disk 'public' langsung
            Storage::disk('public')->putFileAs('dokter_photos', $file, $filename);

            // Simpan path relatif terhadap disk 'public'
            $dokter->foto_dokter = 'dokter_photos/' . $filename;
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