@extends('layouts.app')

@section('title', 'Detail Layanan')

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <span class="text-muted fw-light">Admin / Layanan /</span> Detail Layanan
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Layanan</h5>
                <div>
                    <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="btn btn-primary me-2">
                        <i class="bx bx-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="card">
                            <div class="card-body">
                                @if($layanan->foto_layanan)
                                <img src="{{ asset('storage/'.$layanan->foto_layanan) }}" alt="{{ $layanan->nama_layanan }}" class="img-fluid rounded mb-3 w-100" style="max-height: 250px; object-fit: cover;">
                                @else
                                <div class="d-flex align-items-center justify-content-center bg-label-primary rounded mb-3" style="height: 200px;">
                                    <i class="bx bx-plus-medical fs-1"></i>
                                </div>
                                @endif
                                
                                <h5 class="card-title">{{ $layanan->nama_layanan }}</h5>
                                <p class="card-text text-primary fw-semibold mb-1">{{ $layanan->harga_layanan }}</p>
                                
                                <div class="mb-3">
                                    <span class="badge bg-label-primary">
                                        <i class="bx bx-time me-1"></i> 
                                        {{ $layanan->jam_operasional_mulai ?? '08:00' }} - {{ $layanan->jam_operasional_selesai ?? '17:00' }}
                                    </span>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="btn btn-outline-primary">
                                        <i class="bx bx-edit me-1"></i> Edit Layanan
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                        <i class="bx bx-trash me-1"></i> Hapus Layanan
                                    </button>
                                    <form id="delete-form" action="{{ route('admin.layanan.destroy', $layanan->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="card-title mb-0"><i class="bx bx-info-circle me-2"></i>Deskripsi Layanan</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $layanan->deskripsi_layanan }}</p>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><i class="bx bx-user-pin me-2"></i>Dokter Terkait</h5>
                                <a href="{{ route('admin.dokter.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus"></i> Tambah Dokter
                                </a>
                            </div>
                            <div class="card-body">
                                @if($layanan->dokters->count() > 0)
                                <div class="row">
                                    @foreach($layanan->dokters as $dokter)
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <div class="avatar avatar-md me-3">
                                                @if($dokter->foto_dokter)
                                                <img src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}" class="rounded-circle">
                                                @else
                                                <div class="avatar-initial rounded-circle bg-primary">
                                                    {{ substr($dokter->nama_dokter, 0, 1) }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $dokter->nama_dokter }}</h6>
                                                <small class="text-muted">{{ $dokter->no_telepon }}</small>
                                            </div>
                                            <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="text-center py-3">
                                    <div class="mb-2">
                                        <i class="bx bx-user-x fs-1 text-muted"></i>
                                    </div>
                                    <h6>Belum ada dokter untuk layanan ini</h6>
                                    <p class="text-muted mb-3">Tambahkan dokter untuk menangani layanan ini</p>
                                    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
                                        <i class="bx bx-plus me-1"></i> Tambah Dokter Baru
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus layanan ini? Dokter yang terkait dengan layanan ini akan terpengaruh.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endpush