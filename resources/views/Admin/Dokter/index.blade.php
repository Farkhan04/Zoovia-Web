@extends('layouts.app')

@section('title', 'Kelola Dokter')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold"><i class="bx bx-user-pin me-2 text-primary"></i>Kelola Dokter</h4>
        <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Dokter
        </a>
    </div>
</div>

<div class="row">
    <!-- Search & Filter Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.dokter.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama dokter, layanan..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary" onsubmit="window.location.href = `{{ route('admin.dokter.index') }}?search=${query}`;">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Layanan</option>
                            @foreach(\App\Models\Layanan::all() as $layanan)
                                <option value="{{ $layanan->id }}" {{ request('filter') == $layanan->id ? 'selected' : '' }}>{{ $layanan->nama_layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Dokter Table Card -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Dokter</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Foto</th>
                                <th width="20%">Nama Dokter</th>
                                <th width="20%">Alamat</th>
                                <th width="15%">No. Telepon</th>
                                <th width="15%">Layanan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokters as $index => $dokter)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if($dokter->foto_dokter)
                                                <img src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}" class="rounded-circle" style="width: 70px; height: 70px; object-fit: cover;">
                                            @else
                                                <div class="avatar avatar-lg bg-label-primary">
                                                    <span class="avatar-initial rounded-circle">{{ substr($dokter->nama_dokter, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-nowrap">{{ $dokter->nama_dokter }}</h6>
                                            <small class="text-muted">Dokter</small>
                                        </div>
                                    </td>
                                    <td>{{ $dokter->alamat }}</td>
                                    <td>+62{{ $dokter->no_telepon }}</td>
                                    <td>
                                        @if($dokter->layanan)
                                            <span class="badge bg-label-primary">{{ $dokter->layanan->nama_layanan }}</span>
                                        @else
                                            <span class="badge bg-label-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-icon btn-md btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="bx bx-show" style="color: white;"></i>
                                            </a>
                                            <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-icon btn-md btn-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="bx bx-edit" style="color: white;"></i>
                                            </a>
                                            <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-icon btn-md btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-name="{{ $dokter->nama_dokter }}">
                                                    <i class="bx bx-trash" style="color: white;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <div class="py-3">
                                            <i class="bx bx-user text-secondary" style="font-size: 4rem;"></i>
                                            <h6 class="mt-2">Belum ada dokter yang terdaftar</h6>
                                            <p class="mb-0 text-muted">Tambahkan dokter untuk memulai</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination if needed -->
                @if(isset($dokters) && method_exists($dokters, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $dokters->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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
    
    .badge.bg-label-primary {
        background-color: rgba(105, 108, 255, 0.16) !important;
        color: #696cff;
    }
    
    .badge.bg-label-secondary {
        background-color: rgba(108, 117, 125, 0.16) !important;
        color: #6c757d;
    }
    
    .avatar-lg {
        width: 70px;
        height: 70px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Delete confirmation
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus dokter "${name}"?`,
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