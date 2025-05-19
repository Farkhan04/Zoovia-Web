@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold"><i class="bx bx-book me-2 text-primary"></i>Kelola Artikel</h4>
    </div>
</div>

<div class="row">
    <!-- Search & Filter Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.artikel.index') }}" method="GET" class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari artikel berdasarkan judul, deskripsi, atau penulis..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary w-100">
                            <i class="bx bx-plus me-1"></i> Buat Baru
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Artikel Table Card -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Artikel</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Thumbnail</th>
                                <th width="20%">Judul</th>
                                <th width="25%">Deskripsi</th>
                                <th width="15%">Penulis</th>
                                <th width="10%">Tanggal</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($artikels as $index => $artikel)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($artikel->thumbnail)
                                            <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="img-fluid rounded" style="max-height: 80px;">
                                        @else
                                            <div class="avatar bg-label-primary d-flex align-items-center justify-content-center">
                                                <i class="bx bx-image fs-3"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-nowrap">{{ $artikel->judul }}</h6>
                                    </td>
                                    <td>
                                        <p class="text-truncate mb-0" style="max-width: 250px;" title="{{ $artikel->deskripsi }}">
                                            {{ \Illuminate\Support\Str::limit($artikel->deskripsi, 80) }}
                                        </p>
                                        <a href="{{ route('admin.artikel.show', $artikel->id) }}" class="text-primary small">Baca selengkapnya</a>
                                    </td>
                                    <td>{{ $artikel->penulis }}</td>
                                    <td>{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.artikel.show', $artikel->id) }}" class="btn btn-icon btn-md btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                <i class="bx bx-show" style="color:white"></i>
                                            </a>
                                            <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-icon btn-md btn-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="bx bx-edit" style="color:white"></i>
                                            </a>
                                            <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-icon btn-md btn-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-name="{{ $artikel->judul }}">
                                                    <i class="bx bx-trash" style="color:white"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <div class="py-3">
                                            <i class="bx bx-book-content fs-1 text-secondary"></i>
                                            <h6 class="mt-2">Belum ada artikel</h6>
                                            <p class="mb-0 text-muted">Tambahkan artikel untuk ditampilkan di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $artikels->links() }}
                </div>
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
                    text: `Apakah Anda yakin ingin menghapus artikel "${name}"?`,
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