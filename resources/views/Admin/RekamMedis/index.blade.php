@extends('layouts.app')

@section('title', 'Rekam Medis')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold"><i class="bx bx-plus-medical me-2 text-primary"></i>Rekam Medis Hewan</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRekamMedisModal">
            <i class="bx bx-plus me-1"></i> Tambah Rekam Medis
        </button>
    </div>
</div>

<div class="row">
    <!-- Search & Filter Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.rekammedis.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama hewan atau jenis..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="filter" class="form-select">
                            <option value="">Semua Jenis Hewan</option>
                            <option value="Kucing" {{ request('filter') == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                            <option value="Anjing" {{ request('filter') == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                            <option value="Burung" {{ request('filter') == 'Burung' ? 'selected' : '' }}>Burung</option>
                            <option value="Lainnya" {{ request('filter') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rekam Medis Table Card -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Rekam Medis</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%"></th>
                                <th width="20%">Nama Hewan</th>
                                <th width="15%">Jenis Hewan</th>
                                <th width="10%">Umur</th>
                                <th width="15%">Jumlah Rekam</th>
                                <th width="20%">Terakhir Periksa</th>
                                <th width="15%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hewans as $hewan)
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-sm btn-text-secondary rounded-pill toggle-expand-btn" data-hewan-id="{{ $hewan->id }}">
                                            <i class="bx bx-chevron-down toggle-icon" id="toggle-icon-{{ $hewan->id }}"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <div class="avatar-initial rounded-circle bg-label-{{ $hewan->jenis_hewan == 'Kucing' ? 'warning' : ($hewan->jenis_hewan == 'Anjing' ? 'success' : 'info') }}">
                                                    {{ substr($hewan->nama_hewan, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-nowrap">{{ $hewan->nama_hewan }}</h6>
                                                <small class="text-muted">{{ $hewan->user->name ?? 'Tanpa Pemilik' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-{{ $hewan->jenis_hewan == 'Kucing' ? 'warning' : ($hewan->jenis_hewan == 'Anjing' ? 'success' : 'info') }}">{{ $hewan->jenis_hewan }}</span></td>
                                    <td>{{ $hewan->umur }} tahun</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-semibold me-2">{{ $hewan->rekamMedis->count() }}</span>
                                            <div class="progress w-75" style="height: 8px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: {{ min($hewan->rekamMedis->count() * 10, 100) }}%" 
                                                     aria-valuenow="{{ $hewan->rekamMedis->count() }}" 
                                                     aria-valuemin="0" aria-valuemax="10"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($hewan->rekamMedis->count() > 0)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-calendar me-1 text-primary"></i>
                                                <span>{{ \Carbon\Carbon::parse($hewan->rekamMedis->first()->tanggal)->format('d M Y') }}</span>
                                            </div>
                                        @else
                                            <span class="badge bg-label-secondary">Belum Pernah</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.rekammedis.show', $hewan->id) }}" class="btn btn-icon btn-sm btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <button type="button" class="btn btn-icon btn-sm btn-success" onclick="tambahRekamMedis({{ $hewan->id }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Rekam Medis">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="expandable-row" id="medical-records-{{ $hewan->id }}">
                                    <td colspan="7" class="p-0">
                                        <div class="p-3 bg-light-primary border-start border-primary border-3">
                                            @if($hewan->rekamMedis->count() > 0)
                                                <h6 class="mb-3">Riwayat Rekam Medis</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm mb-3">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Tanggal</th>
                                                                <th>Dokter</th>
                                                                <th>Deskripsi</th>
                                                                <th width="15%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($hewan->rekamMedis as $rekam)
                                                                <tr>
                                                                    <td>{{ \Carbon\Carbon::parse($rekam->tanggal)->format('d M Y') }}</td>
                                                                    <td>{{ $rekam->dokter->nama_dokter }}</td>
                                                                    <td>{{ \Illuminate\Support\Str::limit($rekam->deskripsi, 100) }}</td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <button class="btn btn-icon btn-sm btn-info me-1"
                                                                                onclick="editRekam('{{ $rekam->id }}', '{{ $rekam->deskripsi }}', '{{ \Carbon\Carbon::parse($rekam->tanggal)->format('Y-m-d') }}')"
                                                                                data-bs-toggle="modal" data-bs-target="#editModal">
                                                                                <i class="bx bx-edit-alt"></i>
                                                                            </button>
                                                                            <form action="{{ route('admin.rekammedis.destroy', $rekam->id) }}" method="POST" class="d-inline delete-form">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button" class="btn btn-icon btn-sm btn-danger btn-delete">
                                                                                    <i class="bx bx-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="text-end">
                                                    <a href="{{ route('admin.rekammedis.show', $hewan->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="bx bx-file me-1"></i> Lihat Detail Lengkap
                                                    </a>
                                                </div>
                                            @else
                                                <div class="text-center py-5">
                                                    <div class="mb-3">
                                                        <i class="bx bx-file-blank text-secondary" style="font-size: 4rem;"></i>
                                                    </div>
                                                    <h5 class="mb-2">Belum Ada Catatan Medis</h5>
                                                    <p class="mb-3 text-muted">Silakan tambahkan rekam medis untuk hewan ini.</p>
                                                    <button type="button" class="btn btn-primary" onclick="tambahRekamMedis({{ $hewan->id }})">
                                                        <i class="bx bx-plus me-1"></i> Tambah Rekam Medis
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if(count($hewans) == 0)
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bx bx-search-alt text-secondary" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="mb-2">Data Tidak Ditemukan</h5>
                    <p class="mb-0 text-muted">Tidak ada data yang sesuai dengan pencarian Anda.</p>
                </div>
                @endif
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $hewans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Rekam Medis -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Rekam Medis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.rekammedis.update', 'id') }}" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pemeriksaan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    <input type="hidden" name="rekam_id" id="rekam_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
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
    .expandable-row {
        display: none;
    }
    
    .toggle-icon {
        transition: transform 0.3s ease;
    }
    
    .toggle-icon.rotate {
        transform: rotate(180deg);
    }
    
    .bg-light-primary {
        background-color: rgba(105, 108, 255, 0.08);
    }
    
    .badge.bg-label-warning {
        background-color: rgba(255, 171, 0, 0.16) !important;
        color: #ffab00;
    }
    
    .badge.bg-label-success {
        background-color: rgba(40, 199, 111, 0.16) !important;
        color: #28c76f;
    }
    
    .badge.bg-label-info {
        background-color: rgba(0, 207, 232, 0.16) !important;
        color: #00cfea;
    }
    
    .badge.bg-label-secondary {
        background-color: rgba(108, 117, 125, 0.16) !important;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Function to handle edit rekam medis
    function editRekam(id, deskripsi, tanggal) {
        document.getElementById('rekam_id').value = id;
        document.getElementById('deskripsi').value = deskripsi;
        document.getElementById('tanggal').value = tanggal;
        document.getElementById('editForm').action = '{{ route('admin.rekammedis.update', ':id') }}'.replace(':id', id);
    }

    // Function to pre-select hewan in add modal
    function tambahRekamMedis(hewanId) {
        const modal = new bootstrap.Modal(document.getElementById('addRekamMedisModal'));
        document.getElementById('id_hewan').value = hewanId;
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Toggle expand/collapse
        document.querySelectorAll('.toggle-expand-btn').forEach(button => {
            button.addEventListener('click', function() {
                const hewanId = this.getAttribute('data-hewan-id');
                const expandableRow = document.getElementById('medical-records-' + hewanId);
                const toggleIcon = document.getElementById('toggle-icon-' + hewanId);
                
                if (expandableRow.style.display === 'table-row') {
                    expandableRow.style.display = 'none';
                    toggleIcon.classList.remove('rotate');
                } else {
                    expandableRow.style.display = 'table-row';
                    toggleIcon.classList.add('rotate');
                }
            });
        });
        
        // Delete confirmation
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus rekam medis ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush