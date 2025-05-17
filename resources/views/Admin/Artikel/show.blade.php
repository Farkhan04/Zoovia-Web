@extends('layouts.app')

@section('title', $artikel->judul)

@section('meta_description', Str::limit($artikel->deskripsi, 160))

@section('content')
<!-- Tombol Kembali -->
<div class="mb-4">
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Artikel
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Artikel Header -->
                <h1 class="mb-4">{{ $artikel->judul }}</h1>
                
                <!-- Artikel Meta -->
                <div class="text-muted mb-4">
                    <span class="me-3"><i class="bi bi-person me-1"></i> {{ $artikel->penulis }}</span>
                    <span class="me-3"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($artikel->tanggal)->format('d M Y') }}</span>
                </div>
                
                <!-- Artikel Thumbnail -->
                @if ($artikel->thumbnail)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="img-fluid rounded">
                    </div>
                @endif
                
                <!-- Artikel Content -->
                <div class="article-content mb-4">
                    {!! nl2br(e($artikel->deskripsi)) !!}
                </div>
            </div>
        </div>
        
        <!-- Artikel Actions (Edit/Delete) -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Tindakan</h5>
                <div class="d-flex">
                    <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-primary me-2">
                        <i class="bi bi-pencil me-1"></i> Edit Artikel
                    </a>
                    <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i> Hapus Artikel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .article-content {
        line-height: 1.8;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
    }
</style>
@endpush