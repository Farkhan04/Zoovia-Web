<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Artikel;
use App\Models\Dokter;
use App\Models\Hewan;
use App\Models\Layanan;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan data statistik dan informasi terkini
     */
    public function index()
    {
        // 1. Statistik Umum
        $today = Carbon::now()->toDateString();
        $thisMonth = Carbon::now()->startOfMonth()->toDateString();

        // Statistik Antrian Hari Ini
        $antrianStatistik = Antrian::getTodayQueueSummary();
        
        // Jumlah Layanan Aktif
        $totalLayanan = Layanan::count();

        // Jumlah Dokter Aktif
        $totalDokter = Dokter::count();

        // Total Rekam Medis
        $totalRekamMedis = RekamMedis::count();
        $rekamMedisThisMonth = RekamMedis::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
            
        // Persentase peningkatan rekam medis bulan ini dibandingkan bulan lalu
        $rekamMedisLastMonth = RekamMedis::whereMonth('tanggal', Carbon::now()->subMonth()->month)
            ->whereYear('tanggal', Carbon::now()->subMonth()->year)
            ->count();
        $rekamMedisGrowth = $rekamMedisLastMonth > 0 
            ? round(($rekamMedisThisMonth - $rekamMedisLastMonth) / $rekamMedisLastMonth * 100, 1)
            : 0;

        // 2. Antrian Terkini
        $antrianTerkini = Antrian::with(['user', 'hewan', 'layanan'])
            ->where('tanggal_antrian', $today)
            ->orderBy('status', 'asc')
            ->orderBy('nomor_antrian', 'asc')
            ->take(5)
            ->get();

        // 3. Aktivitas Terkini (Kombinasi antrian dan rekam medis)
        $aktivitasTerkini = $this->getRecentActivities();

        // 4. Layanan Populer
        $layananPopuler = Antrian::select('id_layanan', DB::raw('count(*) as total'))
            ->with('layanan')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('id_layanan')
            ->orderBy('total', 'desc')
            ->take(4)
            ->get();
            
        // Jika kosong, tampilkan semua layanan
        if ($layananPopuler->isEmpty()) {
            $layananPopuler = Layanan::take(4)->get()->map(function ($layanan) {
                $layanan->total = 0;
                return $layanan;
            });
        }
        
        // Hitung total untuk persentase
        $totalLayananUsage = $layananPopuler->sum('total');
        $layananPopuler = $layananPopuler->map(function ($item) use ($totalLayananUsage) {
            $item->percentage = $totalLayananUsage > 0 ? round(($item->total / $totalLayananUsage) * 100) : 0;
            return $item;
        });

        // 5. Dokter Aktif
        $dokterAktif = Dokter::with('layanan')->take(4)->get();
        
        // 6. Artikel Terbaru
        $artikelTerbaru = Artikel::orderBy('created_at', 'desc')->take(3)->get();

        return view('Admin.dashboard', compact(
            'antrianStatistik',
            'totalLayanan',
            'totalDokter',
            'totalRekamMedis',
            'rekamMedisGrowth',
            'antrianTerkini',
            'aktivitasTerkini',
            'layananPopuler',
            'dokterAktif',
            'artikelTerbaru'
        ));
    }

    /**
     * Mendapatkan riwayat aktivitas terbaru dari antrian dan rekam medis
     */
    private function getRecentActivities()
    {
        // Ambil data check-in antrian terbaru
        $antrianCheckins = Antrian::with(['user', 'hewan'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($antrian) {
                return [
                    'type' => 'check-in',
                    'timestamp' => $antrian->created_at,
                    'message' => "{$antrian->nama} check-in dengan {$antrian->hewan->nama_hewan}",
                    'icon' => 'bx-check-circle',
                    'color' => 'success'
                ];
            });
            
        // Ambil rekam medis terbaru
        $rekamMedisBaru = RekamMedis::with(['dokter', 'hewan'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($rekam) {
                return [
                    'type' => 'rekam-medis',
                    'timestamp' => $rekam->created_at,
                    'message' => "Dr. {$rekam->dokter->nama_dokter} selesai memeriksa {$rekam->hewan->nama_hewan}",
                    'icon' => 'bx-edit',
                    'color' => 'info'
                ];
            });
            
        // Ambil antrian yang diproses
        $antrianDiproses = Antrian::with(['user', 'hewan'])
            ->where('status', 'diproses')
            ->orderBy('updated_at', 'desc')
            ->take(2)
            ->get()
            ->map(function ($antrian) {
                return [
                    'type' => 'process',
                    'timestamp' => $antrian->updated_at,
                    'message' => "Admin memanggil antrian {$antrian->nomor_antrian}",
                    'icon' => 'bx-user-voice',
                    'color' => 'warning'
                ];
            });
            
        // Gabungkan semua aktivitas
        $allActivities = $antrianCheckins->concat($rekamMedisBaru)->concat($antrianDiproses);
        
        // Urutkan berdasarkan timestamp terbaru
        $aktivitasTerkini = $allActivities->sortByDesc('timestamp')->take(5)->values();
        
        return $aktivitasTerkini;
    }
}