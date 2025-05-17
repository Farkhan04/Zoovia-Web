@extends('layouts.app')

@section('title', 'Edit Dokter')

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <span class="text-muted fw-light">Admin / Dokter /</span> Edit Dokter
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Edit Dokter</h5>
                <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_dokter" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_dokter') is-invalid @enderror" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $dokter->nama_dokter) }}" placeholder="Masukkan nama dokter" required>
                            @error('nama_dokter')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="id_layanan" class="form-label">Pilih Layanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_layanan') is-invalid @enderror" id="id_layanan" name="id_layanan" required>
                                <option value="" disabled>-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}" {{ old('id_layanan', $dokter->id_layanan) == $layanan->id ? 'selected' : '' }}>
                                    {{ $layanan->nama_layanan }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat dokter" required>{{ old('alamat', $dokter->alamat) }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+62</span>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $dokter->no_telepon) }}" placeholder="8123456789" required>
                            @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Format: 8123456789 (tanpa awalan 0)</small>
                    </div>

                    <div class="mb-4">
                        <label for="foto_dokter" class="form-label">Foto Dokter</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input class="form-control @error('foto_dokter') is-invalid @enderror" type="file" id="foto_dokter" name="foto_dokter" accept="image/*" onchange="previewImage()">
                                @error('foto_dokter')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <img id="preview" src="{{ $dokter->foto_dokter ? asset('storage/'.$dokter->foto_dokter) : asset('Admin/assets/img/avatars/default-doctor.png') }}" alt="Preview" class="img-thumbnail" style="height: 150px; width: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Simpan Perubahan
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
        const input = document.getElementById('foto_dokter');
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Validasi nomor telepon hanya angka
    document.getElementById('no_telepon').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush