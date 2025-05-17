@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<!-- Profile Cards -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="profile-header d-flex flex-column flex-sm-row text-center text-sm-start mb-4">
                <div class="avatar-upload me-4 mb-3 mb-sm-0">
                    <!-- Foto profil tanpa tombol edit di dalamnya -->
                    <div class="avatar-preview mx-auto mx-sm-0">
                        <img id="uploadedAvatar" src="{{ $profile && $profile->photo ? asset('storage/' . $profile->photo) : asset('Admin/assets/img/avatars/1.png') }}"
                            alt="Foto profil" class="rounded-circle">
                    </div>
                    
                    <!-- Tombol upload dan reset terpisah -->
                    <div class="avatar-actions text-center">
                        <button type="button" class="btn btn-primary btn-sm" id="upload-button">
                            <i class="bx bx-upload me-1"></i> Unggah Foto
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="reset-avatar">
                            <i class="bx bx-reset me-1"></i> Reset
                        </button>
                    </div>
                </div>
                
                <div class="profile-info mt-2 mt-sm-0">
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted mb-1">{{ ucfirst($user->role ?? 'User') }}</p>
                    <p class="mb-3">
                        <i class="bx bx-envelope me-1"></i> {{ $user->email }}
                        @if($user->email_verified_at)
                            <span class="badge bg-success ms-1">Terverifikasi</span>
                        @else
                            <span class="badge bg-warning ms-1">Belum Terverifikasi</span>
                        @endif
                    </p>
                    
                    @if($profile && $profile->address)
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bx bx-map me-1"></i>
                        <span>{{ $profile->address }}</span>
                    </div>
                    @endif
                    
                    @if($user->no_hp)
                    <div class="d-flex align-items-center text-muted">
                        <i class="bx bx-phone me-1"></i>
                        <span>{{ $user->no_hp }}</span>
                    </div>
                    @endif
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body pt-4">
                <form id="formAccountSettings" method="POST"
                    action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" 
                    class="needs-validation" novalidate>
                    @csrf
                    <!-- Hidden file input -->
                    <input type="file" id="upload" name="upload" class="d-none"
                        accept="image/png, image/jpeg">

                    <div class="row g-3 mb-4">
                        <!-- Informasi pribadi heading -->
                        <div class="col-12">
                            <h5>Informasi Pribadi</h5>
                        </div>
                        
                        <!-- Nama Depan -->
                        <div class="col-md-6">
                            <label for="NamaDepan" class="form-label">Nama Depan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input class="form-control" type="text" id="NamaDepan"
                                    name="NamaDepan" placeholder="Masukkan nama depan"
                                    value="{{ old('NamaDepan', explode(' ', $user->name)[0] ?? '') }}" />
                            </div>
                        </div>
                        
                        <!-- Nama Belakang -->
                        <div class="col-md-6">
                            <label for="NamaBelakang" class="form-label">Nama Belakang</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control" id="NamaBelakang"
                                    name="NamaBelakang" placeholder="Masukkan nama belakang"
                                    value="{{ old('NamaBelakang', explode(' ', $user->name)[1] ?? '') }}" />
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input class="form-control bg-light" type="email"
                                    id="email" name="email" value="{{ $user->email }}"
                                    readonly />
                            </div>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>
                        
                        <!-- Nomor Telepon -->
                        <div class="col-md-6">
                            <label class="form-label" for="nomortelepon">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="text" id="nomortelepon" name="nomortelepon"
                                    class="form-control" placeholder="8123456789"
                                    value="{{ $user->no_hp }}" />
                            </div>
                        </div>
                        
                        <!-- Alamat -->
                        <div class="col-md-8">
                            <label for="alamat" class="form-label">Alamat</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <input type="text" class="form-control" id="alamat"
                                    name="alamat" placeholder="Masukkan alamat lengkap"
                                    value="{{ old('alamat', $profile->address ?? '') }}" />
                            </div>
                        </div>
                        
                        <!-- Kota -->
                        <div class="col-md-4">
                            <label class="form-label" for="city">Kota</label>
                            <select id="city" name="city" class="form-select">
                                <option value="">Pilih Kota</option>
                                <optgroup label="Jawa Barat">
                                    <option value="Bandung" {{ old('city', $profile->city ?? '') == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                    <option value="Bekasi" {{ old('city', $profile->city ?? '') == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
                                    <option value="Bogor" {{ old('city', $profile->city ?? '') == 'Bogor' ? 'selected' : '' }}>Bogor</option>
                                    <option value="Cimahi" {{ old('city', $profile->city ?? '') == 'Cimahi' ? 'selected' : '' }}>Cimahi</option>
                                    <option value="Cirebon" {{ old('city', $profile->city ?? '') == 'Cirebon' ? 'selected' : '' }}>Cirebon</option>
                                    <option value="Depok" {{ old('city', $profile->city ?? '') == 'Depok' ? 'selected' : '' }}>Depok</option>
                                    <option value="Sukabumi" {{ old('city', $profile->city ?? '') == 'Sukabumi' ? 'selected' : '' }}>Sukabumi</option>
                                    <option value="Tasikmalaya" {{ old('city', $profile->city ?? '') == 'Tasikmalaya' ? 'selected' : '' }}>Tasikmalaya</option>
                                </optgroup>
                                <optgroup label="DKI Jakarta">
                                    <option value="Jakarta Pusat" {{ old('city', $profile->city ?? '') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                    <option value="Jakarta Utara" {{ old('city', $profile->city ?? '') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                                    <option value="Jakarta Barat" {{ old('city', $profile->city ?? '') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                    <option value="Jakarta Selatan" {{ old('city', $profile->city ?? '') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                                    <option value="Jakarta Timur" {{ old('city', $profile->city ?? '') == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                                </optgroup>
                                <optgroup label="Jawa Tengah">
                                    <option value="Semarang" {{ old('city', $profile->city ?? '') == 'Semarang' ? 'selected' : '' }}>Semarang</option>
                                    <option value="Solo" {{ old('city', $profile->city ?? '') == 'Solo' ? 'selected' : '' }}>Solo</option>
                                    <option value="Magelang" {{ old('city', $profile->city ?? '') == 'Magelang' ? 'selected' : '' }}>Magelang</option>
                                </optgroup>
                                <optgroup label="Jawa Timur">
                                    <option value="Surabaya" {{ old('city', $profile->city ?? '') == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                                    <option value="Malang" {{ old('city', $profile->city ?? '') == 'Malang' ? 'selected' : '' }}>Malang</option>
                                    <option value="Sidoarjo" {{ old('city', $profile->city ?? '') == 'Sidoarjo' ? 'selected' : '' }}>Sidoarjo</option>
                                </optgroup>
                                <option value="Lainnya" {{ old('city', $profile->city ?? '') == 'Lainnya' ? 'selected' : '' }}>Kota Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Button group -->
                    <div class="mt-4 text-end">
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

@push('styles')
<style>
    /* Custom profile page styles */
    .profile-header {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        background-color: rgba(105, 108, 255, 0.16);
        padding: 2rem;
    }

    .avatar-upload:hover {
        opacity: 0.9;
        cursor: pointer;
    }

    .avatar-preview {
        position: relative;
        border-radius: 50%;
        overflow: hidden;
        width: 120px;
        height: 120px;
        box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45);
        transition: all 0.3s ease;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-actions {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label {
        transform: scale(0.85) translateY(-0.5rem) translateX(0);
        color: #696cff;
    }

    /* For mobile layout */
    @media (max-width: 767.98px) {
        .avatar-preview {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
        }
    }

    /* Custom scrollbar for city select */
    select.form-select {
        max-height: 200px;
        overflow-y: auto;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle profile image upload
        const uploadInput = document.getElementById('upload');
        const avatarImage = document.getElementById('uploadedAvatar');
        const uploadButton = document.getElementById('upload-button');
        const resetAvatarButton = document.getElementById('reset-avatar');
        const resetFormButton = document.querySelector('button[type="reset"]');
        const defaultImageSrc = avatarImage.src; // Save default image URL
        
        // Trigger file input when upload button is clicked
        uploadButton.addEventListener('click', function() {
            uploadInput.click();
        });
        
        // Show image preview when file selected
        uploadInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    avatarImage.src = e.target.result;
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Handle reset avatar button
        resetAvatarButton.addEventListener('click', function() {
            avatarImage.src = defaultImageSrc;
            uploadInput.value = ''; // Clear file input
        });
        
        // Handle form reset button
        resetFormButton.addEventListener('click', function() {
            avatarImage.src = defaultImageSrc;
            uploadInput.value = ''; // Clear file input
        });
        
        // Form validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endpush