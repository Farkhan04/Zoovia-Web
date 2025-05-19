@extends('layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold"><i class="bx bx-clinic me-2 text-primary"></i>Kelola Layanan</h4>
    </div>
</div>

<div class="row">
    <!-- Search & Filter Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.layanan.index') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari layanan..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary w-100">
                            <i class="bx bx-plus me-1"></i> Tambah Layanan Baru
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Layanan Table Card -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Layanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Foto</th>
                                <th width="20%">Nama Layanan</th>
                                <th width="20%">Deskripsi</th>
                                <th width="15%">Harga</th>
                                <th width="15%">Dokter Terkait</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layanans as $index => $layanan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if($layanan->foto_layanan)
                                                <img src="{{ asset('storage/'.$layanan->foto_layanan) }}" alt="{{ $layanan->nama_layanan }}" class="rounded" style="width: 100px; height: 70px; object-fit: cover;">
                                            @else
                                                <div class="bg-label-primary d-flex align-items-center justify-content-center rounded" style="width: 100px; height: 70px;">
                                                    <i class="bx bx-plus-medical fs-3"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-nowrap">{{ $layanan->nama_layanan }}</h6>
                                            <small class="text-muted">
                                                <i class="bx bx-time text-primary me-1"></i>
                                                {{ $layanan->jam_operasional_mulai ?? '08:00' }} - {{ $layanan->jam_operasional_selesai ?? '17:00' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-truncate mb-0" style="max-width: 200px;" title="{{ $layanan->deskripsi_layanan }}">
                                            {{ \Illuminate\Support\Str::limit($layanan->deskripsi_layanan, 80) }}
                                        </p>
                                        <a href="{{ route('admin.layanan.show', $layanan->id) }}" class="text-primary small">Lihat detail</a>
                                    </td>
                                    <td><span class="fw-semibold">{{ $layanan->harga_layanan }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fw-semibold">{{ $layanan->dokters->count() }}</span>
                                            <div class="progress w-75" style="height: 8px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: {{ min($layanan->dokters->count() * 20, 100) }}%" 
                                                     aria-valuenow="{{ $layanan->dokters->count() }}" 
                                                     aria-valuemin="0" aria-valuemax="5"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.layanan.show', $layanan->id) }}" class="btn btn-icon btn-md btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="bx bx-show" style="color: white;"></i>
                                            </a>
                                            <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="btn btn-icon btn-md btn-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="bx bx-edit" style="color: white;"></i>
                                            </a>
                                            <form action="{{ route('admin.layanan.destroy', $layanan->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-icon btn-md btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-name="{{ $layanan->nama_layanan }}">
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
                                            <i class="bx bx-clinic text-secondary" style="font-size: 4rem;"></i>
                                            <h6 class="mt-2">Belum Ada Layanan</h6>
                                            <p class="mb-0 text-muted">Tambahkan layanan untuk memulai</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination if needed -->
                @if(isset($layanans) && method_exists($layanans, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $layanans->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Layanan Cards (Alternative View) -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Tampilan Kartu Layanan</h5>
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#cardView" aria-expanded="false" aria-controls="cardView">
                    <i class="bx bx-grid me-1"></i> Tampilkan/Sembunyikan
                </button>
            </div>
            <div class="collapse" id="cardView">
                <div class="card-body">
                    <div class="row">
                        @forelse($layanans as $layanan)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0 text-truncate">{{ $layanan->nama_layanan }}</h5>
                                            <small class="text-muted">{{ $layanan->harga_layanan }}</small>
                                        </div>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.layanan.show', $layanan->id) }}">
                                                    <i class="bx bx-show-alt me-1"></i> Detail
                                                </a>
                                                <a class="dropdown-item" href="{{ route('admin.layanan.edit', $layanan->id) }}">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.layanan.destroy', $layanan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item btn-delete-card" data-name="{{ $layanan->nama_layanan }}">
                                                        <i class="bx bx-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center position-relative mb-3">
                                        @if($layanan->foto_layanan)
                                        <img src="{{ asset('storage/'.$layanan->foto_layanan) }}" alt="{{ $layanan->nama_layanan }}" class="w-100 rounded" style="height: 150px; object-fit: cover;">
                                        @else
                                        <div class="w-100 bg-label-primary d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                            <i class="bx bx-plus-medical fs-1"></i>
                                        </div>
                                        @endif
                                        
                                        <div class="position-absolute bottom-0 start-0 ms-3 mb-3">
                                            <span class="badge bg-primary">{{ $layanan->dokters->count() }} Dokter</span>
                                        </div>
                                    </div>
                                    
                                    <p class="card-text text-truncate-3">{{ $layanan->deskripsi_layanan }}</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block">Jam Operasional</small>
                                            <small><i class="bx bx-time text-primary me-1"></i>{{ $layanan->jam_operasional_mulai ?? '08:00' }} - {{ $layanan->jam_operasional_selesai ?? '17:00' }}</small>
                                        </div>
                                        <a href="{{ route('admin.layanan.show', $layanan->id) }}" class="btn btn-outline-primary btn-sm">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <h5>Belum Ada Layanan</h5>
                            <p class="mb-4">Anda belum menambahkan layanan. Silakan tambahkan layanan baru.</p>
                            <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i> Tambah Layanan
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-truncate-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 4.5em;
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
    
    .badge.bg-label-primary {
        background-color: rgba(105, 108, 255, 0.16) !important;
        color: #696cff;
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
        
        // Delete confirmation for table buttons
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = this.getAttribute('data-name');
                
                showDeleteConfirmation(name, form);
            });
        });
        
        // Delete confirmation for card view
        document.querySelectorAll('.btn-delete-card').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = this.getAttribute('data-name');
                
                showDeleteConfirmation(name, form);
            });
        });
        
        function showDeleteConfirmation(name, form) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus layanan "${name}"?`,
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
        }
    });
</script>
@endpush