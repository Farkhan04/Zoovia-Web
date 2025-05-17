@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <span class="text-muted fw-light">Admin / Artikel /</span> Edit Artikel
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Edit Artikel
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </h5>
            <div class="card-body">
                <!-- Form edit -->
                <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                            id="judul" name="judul" value="{{ old('judul', $artikel->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                            id="deskripsi" name="deskripsi" rows="6" required>{{ old('deskripsi', $artikel->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
                                id="penulis" name="penulis" value="{{ old('penulis', $artikel->penulis) }}" required>
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                id="tanggal" name="tanggal" value="{{ old('tanggal', $artikel->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <div class="row">
                            <div class="col-md-9">
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                    id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage()">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                            </div>
                            <div class="col-md-3 text-center">
                                <img id="preview" 
                                    src="{{ $artikel->thumbnail ? asset('storage/'.$artikel->thumbnail) : asset('Admin/assets/img/illustrations/no-image.png') }}" 
                                    alt="Thumbnail" class="img-fluid rounded" style="max-height: 120px; width: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Perbarui Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage() {
        const input = document.getElementById('thumbnail');
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush