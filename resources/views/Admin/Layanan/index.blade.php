@extends('layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-2">
        <span class="text-muted fw-light">Admin /</span> Kelola Layanan
    </h4>
    <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Layanan
    </a>
</div>

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
                                <button type="submit" class="dropdown-item btn-delete" data-name="{{ $layanan->nama_layanan }}">
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
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <h5>Belum Ada Layanan</h5>
                <p class="mb-4">Anda belum menambahkan layanan. Silakan tambahkan layanan baru.</p>
                <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah Layanan
                </a>
            </div>
        </div>
    </div>
    @endforelse
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const name = this.getAttribute('data-name');
                
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
            });
        });
    });
</script>
@endpush