<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Dokter;
use App\Models\Layanan;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    /**
     * Display the landing page with latest articles
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Get latest 3 articles for blog section
            $artikels = Artikel::orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            // Get total articles count for "show more" button
            $total_articles = Artikel::count();

            // Get all doctors data
            $doctors = Dokter::all();
            $layanan = Layanan::all();

            // Return the landing page view with articles and doctors data
            return view('Landing.index', compact('artikels', 'total_articles', 'doctors', 'layanan'));

        } catch (\Exception $e) {
            Log::error('Error loading landing page: ' . $e->getMessage());

            // Return view with empty collections if error occurs
            $artikels = collect();
            $total_articles = 0;
            $doctors = collect();
            return view('Landing.index', compact('artikels', 'total_articles', 'doctors'));
        }
    }

    /**
     * Display all articles page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function articles(Request $request)
    {
        try {
            $query = Artikel::orderBy('tanggal', 'desc');

            // Handle search if provided
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%')
                        ->orWhere('penulis', 'like', '%' . $search . '%');
                });
            }

            // Paginate results
            $artikels = $query->paginate(9); // 9 articles per page (3x3 grid)

            return view('Landing.articles', compact('artikels'));
        } catch (\Exception $e) {
            Log::error('Error loading articles page: ' . $e->getMessage());

            $artikels = Artikel::paginate(9);
            return view('Landing.articles', compact('artikels'));
        }
    }

    /**
     * Show article detail
     *
     * @param int $id
     */
    public function articleDetail($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            // Get related articles (same author or recent articles)
            $related_articles = Artikel::where('id', '!=', $id)
                ->where(function ($query) use ($artikel) {
                    $query->where('penulis', $artikel->penulis)
                        ->orWhereRaw('1=1'); // fallback to all articles
                })
                ->orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            return view('Landing.article-detail', compact('artikel', 'related_articles'));
        } catch (\Exception $e) {
            Log::error('Error loading article detail: ' . $e->getMessage());

            return redirect()->route('landing.articles')->with('error', 'Artikel tidak ditemukan');
        }
    }

    /**
     * Display about page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
         $doctors = Dokter::all();

        // Return the landing page view with articles and doctors data
        return view('Landing.about', compact('doctors'));
    }

    /**
     * Display doctors page
     *
     * @return \Illuminate\View\View
     */
    public function doctors()
    {
        // Get all doctors data
        $doctors = Dokter::all();

        // Return the landing page view with articles and doctors data
        return view('Landing.doctor', compact('doctors'));

    }

    /**
     * Display services page
     *
     * @return \Illuminate\View\View
     */
    public function services()
    {
        $layanan = Layanan::all();

        // Kirim data layanan ke tampilan
        return view('Landing.pelayanan', compact('layanan'));
    }
}