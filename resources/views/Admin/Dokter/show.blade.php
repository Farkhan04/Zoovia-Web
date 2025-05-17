@extends('layouts.app')

@section('title', 'Detail Dokter')

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <span class="text-muted fw-light">Admin / Dokter /</span> Detail Dokter
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Dokter</h5>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="text-center">
                            <div class="card">
                                <div class="card-body">
                                    @if($dokter->foto_dokter)
                                    <img src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                                    @else
                                    <img src="{{ asset('Admin/assets/img/avatars/default-doctor.png') }}" alt="Default" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                                    @endif
                                    
                                    <h4 class="text-primary">{{ $dokter->nama_dokter }}</h4>
                                    <span class="badge bg-label-success rounded-pill mb-3">{{ $dokter->layanan ? $dokter->layanan->nama_layanan : 'Tidak ada layanan' }}</span>
                                    
                                    <div class="d-grid gap-2 mt-2">
                                        <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-primary">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" id="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger w-100" onclick="confirmDelete()">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bx bx-user-pin me-2"></i>Detail Informasi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td style="width: 30%;" class="fw-medium">Nama Lengkap</td>
                                            <td style="width: 2%;">:</td>
                                            <td>{{ $dokter->nama_dokter }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Alamat</td>
                                            <td>:</td>
                                            <td>{{ $dokter->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Nomor Telepon</td>
                                            <td>:</td>
                                            <td>
                                                <a href="tel:+62{{ $dokter->no_telepon }}" class="text-decoration-none">
                                                    +62{{ $dokter->no_telepon }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Layanan</td>
                                            <td>:</td>
                                            <td>
                                                @if($dokter->layanan)
                                                <a href="{{ route('admin.layanan.show', $dokter->layanan->id) }}" class="text-decoration-none">
                                                    {{ $dokter->layanan->nama_layanan }}
                                                </a>
                                                @else
                                                <span class="text-muted">Tidak ada layanan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        @if($dokter->layanan)
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bx bx-clinic me-2"></i>Informasi Layanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    @if($dokter->layanan->foto_layanan)
                                    <img src="{{ asset('storage/'.$dokter->layanan->foto_layanan) }}" alt="{{ $dokter->layanan->nama_layanan }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                    <div class="me-3 d-flex align-items-center justify-content-center bg-label-primary rounded" style="width: 80px; height: 80px;">
                                        <i class="bx bx-plus-medical fs-1"></i>
                                    </div>
                                    @endif
                                    
                                    <div>
                                        <h6 class="mb-0">{{ $dokter->layanan->nama_layanan }}</h6>
                                        <p class="text-muted mb-0">{{ $dokter->layanan->harga_layanan }}</p>
                                        <small class="text-primary">
                                            <i class="bx bx-time-five"></i> 
                                            {{ $dokter->layanan->jam_operasional_mulai ?? '08:00' }} - {{ $dokter->layanan->jam_operasional_selesai ?? '17:00' }}
                                        </small>
                                    </div>
                                </div>
                                
                                <h6 class="mb-2">Deskripsi Layanan:</h6>
                                <p class="mb-0">{{ $dokter->layanan->deskripsi_layanan }}</p>
                            </div>
                        </div>
                        @endif
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
            text: "Apakah Anda yakin ingin menghapus dokter ini?",
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