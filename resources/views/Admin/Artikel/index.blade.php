@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-2">
        <span class="text-muted fw-light">Admin /</span> Kelola Artikel
    </h4>
    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Artikel
    </a>
</div>

<!-- Artikel Table -->
<div class="card">
    <h5 class="card-header">Daftar Artikel</h5>

    <!-- Button Tambah Artikel & search -->
    <div class="d-flex justify-content-between align-items-center mx-3 mt-4 mb-3">
        <!-- Search kiri -->
        <form action="{{ route('admin.artikel.index') }}" method="GET" class="d-flex"
            style="max-width: 300px;">
            <input type="text" name="search" class="form-control me-2"
                placeholder="Cari artikel..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">
                <i class="bx bx-search"></i>
            </button>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Thumbnail</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($artikels as $artikel)
                    <tr>
                        <td>
                            @if ($artikel->thumbnail)
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}"
                                    alt="Thumbnail" width="150">
                            @else
                                <p>No thumbnail available</p>
                            @endif
                        </td>
                        <td>{{ $artikel->judul }}</td>
                        <td class="truncate" title="{{ $artikel->deskripsi }}">
                            {{ \Illuminate\Support\Str::limit($artikel->deskripsi, 100, '...') }}
                            <a href="{{ route('admin.artikel.show', $artikel->id) }}"
                                class="text-primary">Baca lebih</a>
                        </td>
                        <td>{{ $artikel->penulis }}</td>
                        <td>{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d-m-Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <!-- Tombol Lihat -->
                                <a href="{{ route('admin.artikel.show', $artikel->id) }}"
                                    class="btn btn-primary btn-sm me-2">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                                    class="btn btn-info btn-sm me-2">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Tombol Delete -->
                                <form
                                    action="{{ route('admin.artikel.destroy', $artikel->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer">
        {{ $artikels->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .truncate {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush