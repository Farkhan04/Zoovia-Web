@extends('layouts.app')

@section('title', 'Detail Rekam Medis ' . $hewan->nama_hewan)

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold"><i class="bx bx-health me-2 text-primary"></i>Detail Rekam Medis</h4>
            <p class="mb-0 text-muted">Informasi rekam medis untuk hewan {{ $hewan->nama_hewan }}</p>
        </div>
        <div>
            <a href="{{ route('admin.rekammedis.index') }}" class="btn btn-secondary me-2">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRekamMedisModal">
                <i class="bx bx-plus me-1"></i> Tambah Rekam Medis
            </button>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Hewan Card -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Data Hewan</h5>
                <div class="badge bg-label-{{ $hewan->jenis_hewan == 'Kucing' ? 'warning' : ($hewan->jenis_hewan == 'Anjing' ? 'success' : 'info') }}">
                    {{ $hewan->jenis_hewan }}
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-3">
                        <div class="avatar-initial rounded-circle bg-label-{{ $hewan->jenis_hewan == 'Kucing' ? 'warning' : ($hewan->jenis_hewan == 'Anjing' ? 'success' : 'info') }}">
                            {{ substr($hewan->nama_hewan, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $hewan->nama_hewan }}</h4>
                        <span class="text-muted">{{ $hewan->umur }} tahun</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="ps-0" width="40%">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-user text-primary me-2"></i>
                                        <span>Pemilik</span>
                                    </div>
                                </td>
                                <td>:</td>
                                <td class="fw-semibold">{{ $hewan->user->name ?? 'Tidak ada data' }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-category text-primary me-2"></i>
                                        <span>Jenis</span>
                                    </div>
                                </td>
                                <td>:</td>
                                <td class="fw-semibold">{{ $hewan->jenis_hewan }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar text-primary me-2"></i>
                                        <span>Umur</span>
                                    </div>
                                </td>
                                <td>:</td>
                                <td class="fw-semibold">{{ $hewan->umur }} tahun</td>
                            </tr>
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-file text-primary me-2"></i>
                                        <span>Jumlah Rekam</span>
                                    </div>
                                </td>
                                <td>:</td>
                                <td class="fw-semibold">{{ count($rekamMedis) }} catatan</td>
                            </tr>
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-time text-primary me-2"></i>
                                        <span>Terakhir Periksa</span>
                                    </div>
                                </td>
                                <td>:</td>
                                <td class="fw-semibold">
                                    @if(count($rekamMedis) > 0)
                                        {{ \Carbon\Carbon::parse($rekamMedis->first()->tanggal)->format('d M Y') }}
                                    @else
                                        <span class="badge bg-label-secondary">Belum Pernah</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Riwayat Rekam Medis Card -->
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Riwayat Rekam Medis</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-export me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bx bxs-file-pdf me-2"></i>PDF</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bx bxs-file-doc me-2"></i>Word</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bx bxs-spreadsheet me-2"></i>Excel</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="timeline-container p-4">
                    @if(count($rekamMedis) > 0)
                        <div class="timeline">
                            @foreach($rekamMedis as $index => $rekam)
                                <div class="timeline-item {{ $index === 0 ? 'pb-4' : 'py-4' }}">
                                    <div class="timeline-indicator timeline-indicator-primary">
                                        <i class="bx bx-plus-medical"></i>
                                    </div>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            <div class="d-flex flex-wrap justify-content-between">
                                                <h6 class="mb-0">Pemeriksaan oleh {{ $rekam->dokter->nama_dokter }}</h6>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-muted me-3">{{ \Carbon\Carbon::parse($rekam->tanggal)->format('d M Y') }}</span>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-icon btn-sm btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a href="javascript:void(0);" class="dropdown-item" 
                                                                   onclick="editRekam('{{ $rekam->id }}', '{{ $rekam->deskripsi }}', '{{ \Carbon\Carbon::parse($rekam->tanggal)->format('Y-m-d') }}')"
                                                                   data-bs-toggle="modal" data-bs-target="#editModal">
                                                                    <i class="bx bx-edit-alt me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('admin.rekammedis.destroy', $rekam->id) }}" method="POST" class="delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="dropdown-item btn-delete">
                                                                        <i class="bx bx-trash me-2"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column pb-2">
                                            <div class="mb-1 description">{{ $rekam->deskripsi }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bx bx-file-blank text-secondary" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="mb-2">Belum Ada Rekam Medis</h5>
                            <p class="mb-3 text-muted">Belum ada catatan rekam medis untuk hewan ini.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRekamMedisModal">
                                <i class="bx bx-plus me-1"></i> Tambah Rekam Medis
                            </button>
                        </div>
                    @endif
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
                    <input type="hidden" name="id_hewan" value="{{ $hewan->id }}">
                    
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
    .timeline-container {
        position: relative;
        overflow-y: auto;
        height: calc(100% - 1rem);
    }
    
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        border-left: 1px solid #e0e0e0;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-indicator {
        position: absolute;
        left: -2.15rem;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        background-color: #e0e0e0;
    }
    
    .timeline-indicator-primary {
        background-color: #696cff;
    }
    
    .timeline-event {
        position: relative;
        padding-left: 1rem;
    }
    
    .timeline-header {
        padding-bottom: 0.5rem;
    }
    
    .description {
        white-space: pre-line;
    }
    
    /* Custom badge colors */
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

    document.addEventListener('DOMContentLoaded', function() {
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