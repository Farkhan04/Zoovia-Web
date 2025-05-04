<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Artikel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ArtikelController extends Controller
{
    // Menampilkan daftar artikel
    public function index()
    {
        $artikels = Artikel::all();
        return view('admin.artikel.index', compact('artikels'));
    }

    // Menampilkan form untuk membuat artikel baru
    public function create()
    {
        return view('admin.artikel.create');
    }

    // Menyimpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'penulis' => 'required',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image',
        ]);

        $artikel = new Artikel();
        $artikel->judul = $request->judul;
        $artikel->deskripsi = $request->deskripsi;
        $artikel->penulis = $request->penulis;
        $artikel->tanggal = $request->tanggal;

        // Upload gambar thumbnail ke storage/app/public/thumbnails
        if ($request->hasFile('thumbnail')) {
            // Mendapatkan ekstensi file gambar
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            
            // Membuat nama file yang lebih pendek
            $newName = Str::random(5) . '.' . $extension;
            
            // Menyimpan gambar dengan nama baru
            $path = $request->file('thumbnail')->storeAs('public/thumbnails', $newName);
            
            // Log untuk memastikan gambar disimpan di folder yang benar
            Log::info('Gambar berhasil disimpan di: ' . $path);
            
            // Menyimpan path relatif gambar di database
            $artikel->thumbnail = str_replace('public/', '', $path);
        }

        $artikel->save();

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dibuat');
    }

    // Menampilkan form untuk mengedit artikel
    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    // Memperbarui artikel yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'penulis' => 'required',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image',
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->judul = $request->judul;
        $artikel->deskripsi = $request->deskripsi;
        $artikel->penulis = $request->penulis;
        $artikel->tanggal = $request->tanggal;

        if ($request->hasFile('thumbnail')) {
            // Mendapatkan ekstensi file gambar
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            
            // Membuat nama file yang lebih pendek
            $newName = Str::random(5) . '.' . $extension;  // 12 karakter acak
            
            // Menyimpan gambar dengan nama baru
            $path = $request->file('thumbnail')->storeAs('public/thumbnails', $newName);
            
            // Menyimpan path relatif gambar
            $artikel->thumbnail = str_replace('public/', '', $path);
        }
        $artikel->save();

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    // Menghapus artikel
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
