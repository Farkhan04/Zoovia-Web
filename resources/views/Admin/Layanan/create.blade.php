@extends('layouts.app')

@section('title', 'Tambah Layanan')

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <span class="text-muted fw-light">Admin / Layanan /</span> Tambah Layanan
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Tambah Layanan</h5>
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="nama_layanan" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}" placeholder="Masukkan nama layanan" required>
                            @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="harga_layanan" class="form-label">Harga Layanan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('harga_layanan') is-invalid @enderror" id="harga_layanan" name="harga_layanan" value="{{ old('harga_layanan') }}" placeholder="Contoh: 150.000" required>
                                @error('harga_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jam_operasional_mulai" class="form-label">Jam Operasional Mulai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_operasional_mulai') is-invalid @enderror" id="jam_operasional_mulai" name="jam_operasional_mulai" value="{{ old('jam_operasional_mulai', '08:00') }}" required>
                            @error('jam_operasional_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="jam_operasional_selesai" class="form-label">Jam Operasional Selesai <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_operasional_selesai') is-invalid @enderror" id="jam_operasional_selesai" name="jam_operasional_selesai" value="{{ old('jam_operasional_selesai', '17:00') }}" required>
                            @error('jam_operasional_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jam operasional digunakan untuk batasan pendaftaran antrian</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_layanan" class="form-label">Deskripsi Layanan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi_layanan') is-invalid @enderror" id="deskripsi_layanan" name="deskripsi_layanan" rows="4" placeholder="Masukkan deskripsi lengkap tentang layanan" required>{{ old('deskripsi_layanan') }}</textarea>
                        @error('deskripsi_layanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="foto_layanan" class="form-label">Foto Layanan</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input class="form-control @error('foto_layanan') is-invalid @enderror" type="file" id="foto_layanan" name="foto_layanan" accept="image/*" onchange="previewImage()">
                                @error('foto_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="border rounded p-2">
                                    <img id="preview" src="{{ asset('Admin/assets/img/illustrations/service-placeholder.png') }}" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Simpan
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
        const input = document.getElementById('foto_layanan');
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Format harga layanan
    document.getElementById('harga_layanan').addEventListener('input', function() {
        // Hapus karakter selain angka
        let value = this.value.replace(/\D/g, '');
        
        // Format dengan separator ribuan
        if (value) {
            value = parseInt(value).toLocaleString('id-ID');
        }
        
        this.value = value;
    });
    
    // Form validation untuk jam operasional
    document.querySelector('form').addEventListener('submit', function(e) {
        const jamMulai = document.getElementById('jam_operasional_mulai').value;
        const jamSelesai = document.getElementById('jam_operasional_selesai').value;
        
        if (jamMulai >= jamSelesai) {
            e.preventDefault();
            alert('Jam operasional selesai harus lebih dari jam operasional mulai');
            return false;
        }
    });
</script>
@endpush