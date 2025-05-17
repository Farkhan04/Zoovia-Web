@extends('layouts.app')

@section('title', 'Kelola Dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-2">
        <span class="text-muted fw-light">Admin /</span> Kelola Dokter
    </h4>
    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Dokter
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" id="dokterTable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Foto</th>
                        <th>Nama Dokter</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Layanan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($dokters as $index => $dokter)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($dokter->foto_dokter)
                            <img src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                            <img src="{{ asset('Admin/assets/img/avatars/default-doctor.png') }}" alt="Default" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </td>
                        <td><strong>{{ $dokter->nama_dokter }}</strong></td>
                        <td>{{ $dokter->alamat }}</td>
                        <td>{{ $dokter->no_telepon }}</td>
                        <td>{{ $dokter->layanan ? $dokter->layanan->nama_layanan : 'Tidak ada' }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.dokter.show', $dokter->id) }}">
                                        <i class="bx bx-show-alt me-1"></i> Detail
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.dokter.edit', $dokter->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item btn-delete" data-name="{{ $dokter->nama_dokter }}">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data dokter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // DataTable initialization
        $('#dokterTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari dokter...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
            }
        });

        // Delete confirmation
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const name = $(this).data('name');
            
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
</script>
@endpush