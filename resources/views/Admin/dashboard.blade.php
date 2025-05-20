@extends('layouts.app')

@section('title', 'Dashboard Puskeswan')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold">Dashboard Puskeswan</h4>
                        <p class="mb-0 text-muted">Selamat datang di sistem administrasi Pusat Kesehatan Hewan</p>
                    </div>
                    <div class="avatar avatar-lg bg-label-primary p-2">
                        <i class="bx bx-plus-medical fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Summary -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Antrian Hari Ini</h5>
                        <h2 class="fw-bold mb-0 text-primary" id="total-antrian">{{ $antrianStatistik['total'] ?? 0 }}</h2>
                        <p class="mb-0 mt-1">
                            <span class="text-{{ $antrianStatistik['waiting'] > 0 ? 'warning' : 'muted' }} me-2">
                                <i class="bx bx-time-five"></i> {{ $antrianStatistik['waiting'] ?? 0 }} menunggu
                            </span>
                        </p>
                    </div>
                    <div class="avatar bg-label-primary p-2">
                        <i class="bx bx-group fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Layanan Aktif</h5>
                        <h2 class="fw-bold mb-0 text-success" id="total-layanan">{{ $totalLayanan ?? 0 }}</h2>
                        <p class="mb-0 mt-1">
                            <span class="text-muted me-1">
                                <i class="bx bx-clinic"></i> Layanan tersedia
                            </span>
                        </p>
                    </div>
                    <div class="avatar bg-label-success p-2">
                        <i class="bx bx-clinic fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Dokter Aktif</h5>
                        <h2 class="fw-bold mb-0 text-info" id="total-dokter">{{ $totalDokter ?? 0 }}</h2>
                        <p class="mb-0 mt-1">
                            <span class="text-info me-1">
                                <i class="bx bx-user-pin"></i> Tersedia hari ini
                            </span>
                        </p>
                    </div>
                    <div class="avatar bg-label-info p-2">
                        <i class="bx bx-user-pin fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Rekam Medis</h5>
                        <h2 class="fw-bold mb-0 text-warning" id="total-rekam">{{ $totalRekamMedis ?? 0 }}</h2>
                    </div>
                    <div class="avatar bg-label-warning p-2">
                        <i class="bx bx-file fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Cards -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="card shadow-none bg-label-success h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-user-voice mb-2 fs-1"></i>
                                <h5 class="mb-2">Panggil Antrian</h5>
                                <p class="mb-3">Panggil pasien selanjutnya dalam antrian.</p>
                                <a href="{{ route('admin.antrian.callnext') }}" class="btn btn-success">Panggil Antrian</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="card shadow-none bg-label-info h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-plus-medical mb-2 fs-1"></i>
                                <h5 class="mb-2">Tambah Rekam Medis</h5>
                                <p class="mb-3">Catat rekam medis pasien baru.</p>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addRekamMedisModal">Tambah Baru</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="card shadow-none bg-label-warning h-100">
                            <div class="card-body text-center">
                                <i class="bx bx-book mb-2 fs-1"></i>
                                <h5 class="mb-2">Buat Artikel</h5>
                                <p class="mb-3">Tambahkan artikel edukasi baru.</p>
                                <a href="{{ route('admin.artikel.create') }}" class="btn btn-warning">Tulis Artikel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Antrian dan Aktivitas -->
<div class="row mb-4">
    <!-- Antrian Aktif -->
    <div class="col-xl-8 col-lg-7 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Antrian Terkini</h5>
                <a href="{{ route('admin.antrian.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover border-top m-0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pasien</th>
                                <th>Hewan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrianTerkini as $antrian)
                            <tr>
                                <td><strong>{{ $antrian->nomor_antrian }}</strong></td>
                                <td>{{ $antrian->user->name }}</td>
                                <td>{{ $antrian->hewan->nama_hewan }} ({{ $antrian->hewan->jenis_hewan }})</td>
                                <td>{{ $antrian->layanan->nama_layanan }}</td>
                                <td>
                                    @if($antrian->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($antrian->status == 'diproses')
                                        <span class="badge bg-info">Diproses</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.antrian.show', $antrian->id) }}" class="btn btn-md btn-icon btn-primary">
                                        <i class="bx bx-show" style="color: white;"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">Tidak ada antrian hari ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Aktivitas Terkini -->
    <div class="col-xl-4 col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Aktivitas Terkini</h5>
            </div>
            <div class="card-body px-0">
                <div class="timeline-vertical py-0">
                    @forelse($aktivitasTerkini as $aktivitas)
                    <div class="timeline-item mb-3 ps-4 border-start">
                        <span class="timeline-indicator-dot bg-primary"></span>
                        <div class="d-flex flex-column p-3 pb-0">
                            <small class="text-muted mb-1">{{ $aktivitas['timestamp']->diffForHumans() }}</small>
                            <div class="d-flex">
                                <span class="me-2"><i class="bx {{ $aktivitas['icon'] }} text-{{ $aktivitas['color'] }}"></i></span>
                                <span>{!! $aktivitas['message'] !!}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3">
                        <div class="mb-2">
                            <i class="bx bx-info-circle fs-1 text-muted"></i>
                        </div>
                        <h6>Belum ada aktivitas tercatat</h6>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Layanan & Dokter Populer -->
<div class="row">
    <!-- Layanan Populer -->
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Layanan</h5>
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @forelse($layananPopuler as $layanan)
                    <li class="d-flex mb-3 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-{{ ['primary', 'success', 'info', 'warning'][$loop->index % 4] }}">
                                <i class="bx bx-{{ ['plus-medical', 'clinic', 'cut', 'donate-blood'][$loop->index % 4] }}"></i>
                            </span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">{{ $layanan->layanan->nama_layanan ?? $layanan->nama_layanan }}</h6>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($layanan->layanan->deskripsi_layanan ?? $layanan->deskripsi_layanan, 50) }}</small>
                            </div>
                            <div class="badge bg-label-{{ ['primary', 'success', 'info', 'warning'][$loop->index % 4] }} rounded-pill">{{ $layanan->percentage }}%</div>
                        </div>
                    </li>
                    @empty
                    <li class="text-center py-4">
                        <div class="mb-2">
                            <i class="bx bx-store fs-1 text-muted"></i>
                        </div>
                        <h6>Belum ada layanan yang tersedia</h6>
                        <p class="mb-0 text-muted">Tambahkan layanan baru untuk mulai melacak popularitas</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Dokter Aktif -->
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Dokter Aktif Hari Ini</h5>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-sm btn-outline-primary">Kelola Dokter</a>
            </div>
            <div class="card-body">
                @forelse($dokterAktif as $dokter)
                <div class="d-flex align-items-center mb-3 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                        @if($dokter->foto_dokter)
                            <img src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}" class="rounded-circle">
                        @else
                            <div class="avatar-initial rounded-circle bg-label-{{ ['primary', 'success', 'info', 'warning'][$loop->index % 4] }}">
                                {{ substr($dokter->nama_dokter, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">{{ $dokter->nama_dokter }}</h6>
                            <small class="text-muted">{{ $dokter->layanan ? $dokter->layanan->nama_layanan : 'Tidak ada layanan' }}</small>
                        </div>
                        <span class="badge bg-success rounded-pill">Tersedia</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <div class="mb-2">
                        <i class="bx bx-user-pin fs-1 text-muted"></i>
                    </div>
                    <h6>Belum ada dokter yang terdaftar</h6>
                    <p class="mb-3 text-muted">Tambahkan dokter untuk memulai</p>
                    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Tambah Dokter
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Artikel Terbaru -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Artikel Terbaru</h5>
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($artikelTerbaru as $artikel)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-none bg-transparent border">
                            @if($artikel->thumbnail)
                                <img class="card-img-top" src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->judul }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="d-flex justify-content-center align-items-center bg-light" style="height: 200px;">
                                    <i class="bx bx-image-alt fs-1 text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $artikel->judul }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($artikel->deskripsi, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        <i class="bx bx-user me-1"></i> {{ $artikel->penulis }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bx bx-calendar me-1"></i> {{ $artikel->tanggal->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <div class="mb-2">
                            <i class="bx bx-book-content fs-1 text-muted"></i>
                        </div>
                        <h5>Belum Ada Artikel</h5>
                        <p class="mb-3">Buat artikel untuk memberikan informasi kesehatan hewan kepada pengunjung</p>
                        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Buat Artikel Baru
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Rekam Medis -->
<div class="modal fade" id="addRekamMedisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Rekam Medis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.rekammedis.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_hewan" class="form-label">Hewan</label>
                        <select name="id_hewan" id="id_hewan" class="form-select" required>
                            <option value="">-- Pilih Hewan --</option>
                            @foreach(\App\Models\Hewan::all() as $hewan)
                                <option value="{{ $hewan->id }}">{{ $hewan->nama_hewan }} ({{ $hewan->jenis_hewan }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="id_dokter" class="form-label">Dokter</label>
                        <select name="id_dokter" id="id_dokter" class="form-select" required>
                            <option value="">-- Pilih Dokter --</option>
                            @foreach(\App\Models\Dokter::all() as $dokter)
                                <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_baru" class="form-label">Tanggal Pemeriksaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" name="tanggal" id="tanggal_baru" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi_baru" class="form-label">Deskripsi Pemeriksaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                            <textarea name="deskripsi" id="deskripsi_baru" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styling untuk timeline */
    .timeline-vertical {
        position: relative;
        padding-left: 0.25rem;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-indicator-dot {
        position: absolute;
        left: -0.35rem;
        top: 1rem;
        height: 0.75rem;
        width: 0.75rem;
        border-radius: 50%;
    }
    
    /* Card hover effects */
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Styling untuk badges */
    .badge {
        padding: 0.5em 0.8em;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Animasi counter untuk statistik
        function animateCounter(el, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                el.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
        
        // Jalankan animasi counter pada statistik
        const totalAntrian = document.getElementById('total-antrian');
        const totalLayanan = document.getElementById('total-layanan');
        const totalDokter = document.getElementById('total-dokter');
        const totalRekam = document.getElementById('total-rekam');
        
        animateCounter(totalAntrian, 0, parseInt(totalAntrian.innerText), 1000);
        animateCounter(totalLayanan, 0, parseInt(totalLayanan.innerText), 1000);
        animateCounter(totalDokter, 0, parseInt(totalDokter.innerText), 1000);
        animateCounter(totalRekam, 0, parseInt(totalRekam.innerText), 1000);
    });
</script>
@endpush