<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    // Menampilkan daftar artikel
    public function index(Request $request)
    {
        $query = Artikel::query();

        // Mengecek jika ada parameter pencarian
        if ($request->has('search')) {
            $search = $request->get('search');

            // Menambahkan kondisi pencarian
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('penulis', 'like', '%' . $search . '%');
            });
        }

        // Mendapatkan data artikel yang telah difilter
        $artikels = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Mengembalikan view dengan data artikel
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
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload thumbnail if exists
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $this->uploadThumbnail($request->file('thumbnail'));
            }

            // Create new article
            $artikel = Artikel::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'penulis' => $request->penulis,
                'tanggal' => $request->tanggal,
                'thumbnail' => $thumbnailPath,
            ]);

            return redirect()->route('admin.artikel.index')
                ->with('success', 'Artikel berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan artikel')
                ->withInput();
        }
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
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $artikel = Artikel::findOrFail($id);

            // Handle thumbnail upload if exists
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                $this->deleteThumbnail($artikel->thumbnail);

                // Upload new thumbnail
                $thumbnailPath = $this->uploadThumbnail($request->file('thumbnail'));
                $artikel->thumbnail = $thumbnailPath;
            }

            // Update article data
            $artikel->judul = $request->judul;
            $artikel->deskripsi = $request->deskripsi;
            $artikel->penulis = $request->penulis;
            $artikel->tanggal = $request->tanggal;
            $artikel->save();

            return redirect()->route('admin.artikel.index')
                ->with('success', 'Artikel berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui artikel')
                ->withInput();
        }
    }

    // Menghapus artikel
    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            // Delete thumbnail if exists
            $this->deleteThumbnail($artikel->thumbnail);

            // Delete article
            $artikel->delete();

            return redirect()->route('admin.artikel.index')
                ->with('success', 'Artikel berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus artikel');
        }
    }

    // Helper method untuk upload thumbnail
    private function uploadThumbnail($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'artikel_' . time() . '_' . Str::random(10) . '.' . $extension;
        $path = $file->storeAs('artikel_photos', $filename, 'public');
        return $path;
    }

    // Helper method untuk menghapus thumbnail
    private function deleteThumbnail($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Menampilkan detail artikel
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.show', compact('artikel'));
    }
}