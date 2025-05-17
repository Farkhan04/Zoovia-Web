<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Layanan;
use App\Models\RekamMedis;
use App\Events\AntrianUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AntrianController extends Controller
{
    /**
     * Menampilkan daftar antrian.
     */
    public function index(Request $request)
    {
        // Filter berdasarkan status jika diberikan
        $status = $request->query('status');
        
        // Query dasar
        $query = Antrian::with(['user', 'hewan', 'layanan']);
        
        // Filter berdasarkan status jika diberikan
        if ($status && in_array($status, ['menunggu', 'diproses', 'selesai'])) {
            $query->where('status', $status);
        }
        
        // Filter berdasarkan tanggal
        $date = $request->query('date') ? $request->query('date') : now()->toDateString();
        $query->where('tanggal_antrian', $date);
        
        // Ambil data dan urutkan
        $antrian = $query->orderBy('nomor_antrian', 'asc')->get();
        
        // Ambil ringkasan antrian untuk tanggal tersebut
        $summary = Antrian::where('tanggal_antrian', $date)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = "menunggu" THEN 1 ELSE 0 END) as waiting')
            ->selectRaw('SUM(CASE WHEN status = "diproses" THEN 1 ELSE 0 END) as processing')
            ->selectRaw('SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as completed')
            ->first();
            
        // Ambil data antrian yang sedang diproses
        $currentQueue = Antrian::where('tanggal_antrian', $date)
            ->where('status', 'diproses')
            ->orderBy('nomor_antrian')
            ->first();
            
        // Ambil data antrian berikutnya yang menunggu
        $nextQueue = Antrian::where('tanggal_antrian', $date)
            ->where('status', 'menunggu')
            ->orderBy('nomor_antrian')
            ->first();

        return view('admin.antrian.index', compact('antrian', 'summary', 'currentQueue', 'nextQueue', 'status', 'date'));
    }

    /**
     * Menampilkan detail antrian.
     *
     * @param int $id
     */
    public function show($id)
    {
        $antrian = Antrian::with(['user', 'hewan', 'layanan'])->findOrFail($id);
        $dokters = Dokter::where('id_layanan', $antrian->id_layanan)->get();
        
        return view('admin.antrian.show', compact('antrian', 'dokters'));
    }

    /**
     * Memproses check-in antrian (scan barcode atau input ID).
     *
     * @param \Illuminate\Http\Request $request
     */
    public function checkIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'antrian_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $antrianId = $request->antrian_id;
            $antrian = Antrian::findOrFail($antrianId);
            
            // Hanya antrian dengan status 'menunggu' yang dapat di-check-in
            if ($antrian->status !== 'menunggu') {
                return redirect()->back()->with('error', 'Antrian sudah diproses atau selesai.');
            }
            
            return redirect()->route('admin.antrian.confirm', $antrian->id);
            
        } catch (\Exception $e) {
            Log::error('Error saat check-in antrian: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Antrian tidak ditemukan.');
        }
    }

    /**
     * Menampilkan halaman konfirmasi antrian setelah check-in.
     *
     * @param int $id
     */
    public function confirmCheckIn($id)
    {
        $antrian = Antrian::with(['user', 'hewan', 'layanan'])->findOrFail($id);
        return view('admin.antrian.confirm', compact('antrian'));
    }

    /**
     * Mengupdate status antrian menjadi diproses setelah konfirmasi.
     *
     * @param int $id
     */
    public function processQueue($id)
    {
        try {
            DB::beginTransaction();
            
            $antrian = Antrian::findOrFail($id);
            $antrian->status = 'diproses';
            $antrian->save();
            
            DB::commit();
            
            // Broadcast event untuk update real-time
            event(new AntrianUpdated('update-status', $antrian->load(['user', 'hewan', 'layanan']), Antrian::getTodayQueueSummary()));
            
            return redirect()->route('admin.antrian.show', $antrian->id)
                ->with('success', 'Antrian berhasil diproses.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat memproses antrian: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses antrian.');
        }
    }

    /**
     * Menyelesaikan antrian dan menambahkan rekam medis.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function completeQueue(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_dokter' => 'required|exists:dokter,id',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Update status antrian menjadi selesai
            $antrian = Antrian::findOrFail($id);
            $antrian->status = 'selesai';
            $antrian->save();
            
            // Tambahkan rekam medis
            $rekamMedis = new RekamMedis();
            $rekamMedis->id_hewan = $antrian->id_hewan;
            $rekamMedis->id_dokter = $request->id_dokter;
            $rekamMedis->deskripsi = $request->deskripsi;
            $rekamMedis->save();
            
            DB::commit();
            
            // Broadcast event untuk update real-time
            event(new AntrianUpdated('update-status', $antrian->load(['user', 'hewan', 'layanan']), Antrian::getTodayQueueSummary()));
            
            return redirect()->route('admin.antrian.index')
                ->with('success', 'Antrian selesai dan rekam medis berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyelesaikan antrian: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyelesaikan antrian.');
        }
    }

    /**
     * Menampilkan halaman untuk scanning barcode.
     *
     */
    public function scanBarcode()
    {
        return view('admin.antrian.scan');
    }

    /**
     * Mencari antrian berdasarkan ID untuk check-in.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function searchAntrian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $search = $request->search;
            
            // Coba cari berdasarkan ID antrian
            $antrian = Antrian::where('id', $search)
                ->orWhere('nomor_antrian', $search)
                ->first();
            
            if (!$antrian) {
                return redirect()->back()
                    ->with('error', 'Antrian tidak ditemukan.');
            }
            
            return redirect()->route('admin.antrian.confirm', $antrian->id);
            
        } catch (\Exception $e) {
            Log::error('Error saat mencari antrian: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mencari antrian.');
        }
    }

    /**
     * Panggil antrian berikutnya.
     */
    public function callNextQueue()
    {
        try {
            // Cari antrian berikutnya yang menunggu
            $nextQueue = Antrian::where('tanggal_antrian', now()->toDateString())
                ->where('status', 'menunggu')
                ->orderBy('nomor_antrian')
                ->first();
            
            if (!$nextQueue) {
                return redirect()->route('admin.antrian.index')
                    ->with('error', 'Tidak ada antrian berikutnya.');
            }
            
            return redirect()->route('admin.antrian.confirm', $nextQueue->id);
            
        } catch (\Exception $e) {
            Log::error('Error saat memanggil antrian berikutnya: ' . $e->getMessage());
            
            return redirect()->route('admin.antrian.index')
                ->with('error', 'Terjadi kesalahan saat memanggil antrian berikutnya.');
        }
    }
}