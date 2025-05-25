<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Detail Antrian - Zoovia</title>

    <meta name="description" content="" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Admin/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('Admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/config.js') }}"></script>
    
    <!-- Pusher -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('Admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('Admin.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Breadcrumb -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb breadcrumb-style1 mb-0">
                                                <li class="breadcrumb-item">
                                                    <a href="{{ route('admin.antrian.index') }}">Daftar Antrian</a>
                                                </li>
                                                <li class="breadcrumb-item active">Detail Antrian</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Informasi Antrian -->
                            <div class="col-xl-4 col-lg-5 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Informasi Antrian</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-4">
                                            <div class="badge fs-4 mb-2 
                                                @if($antrian->status == 'menunggu') bg-warning text-dark 
                                                @elseif($antrian->status == 'diproses') bg-info 
                                                @else bg-success @endif">
                                                {{ ucfirst($antrian->status) }}
                                            </div>
                                            <h2 class="mb-1">Antrian #{{ $antrian->nomor_antrian }}</h2>
                                            <p class="text-muted">{{ \Carbon\Carbon::parse($antrian->tanggal_antrian)->format('d F Y') }}</p>
                                        </div>

                                        <div class="divider">
                                            <div class="divider-text">Detail Antrian</div>
                                        </div>

                                        <div class="info-container">
                                            <div class="mb-3 row">
                                                <div class="col-md-4 fw-bold">Nama</div>
                                                <div class="col-md-8">{{ $antrian->nama }}</div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-4 fw-bold">Keluhan</div>
                                                <div class="col-md-8">{{ $antrian->keluhan }}</div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-4 fw-bold">Layanan</div>
                                                <div class="col-md-8">{{ $antrian->layanan->nama_layanan }}</div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-md-4 fw-bold">Tanggal</div>
                                                <div class="col-md-8">{{ \Carbon\Carbon::parse($antrian->created_at)->format('d F Y, H:i') }}</div>
                                            </div>
                                        </div>

                                        <div class="divider">
                                            <div class="divider-text">Aksi</div>
                                        </div>

                                        <div class="d-flex justify-content-center gap-2">
                                            @if($antrian->status == 'menunggu')
                                                <form action="{{ route('admin.antrian.process', $antrian->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="icon-base bx bx-play-circle me-1"></i> Proses Antrian
                                                    </button>
                                                </form>
                                            @elseif($antrian->status == 'diproses')
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeQueueModal">
                                                    <i class="icon-base bx bx-check-circle me-1"></i> Selesai & Tambah Rekam Medis
                                                </button>
                                            @else
                                                <a href="{{ route('admin.antrian.index') }}" class="btn btn-secondary">
                                                    <i class="icon-base bx bx-arrow-back me-1"></i> Kembali
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Pemilik dan Hewan -->
                            <div class="col-xl-8 col-lg-7 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Informasi Pemilik</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">Nama Pemilik</div>
                                                    <div class="col-md-8">{{ $antrian->user->name }}</div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">Email</div>
                                                    <div class="col-md-8">{{ $antrian->user->email }}</div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">No. Telepon</div>
                                                    <div class="col-md-8">{{ $antrian->user->no_hp ?? '-' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <div class="avatar avatar-xl mb-3">
                                                    <img src="{{ asset('Admin/assets/img/avatars/1.png') }}" alt="User Avatar" class="rounded-circle">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Informasi Hewan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">Nama Hewan</div>
                                                    <div class="col-md-8">{{ $antrian->hewan->nama_hewan }}</div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">Jenis Hewan</div>
                                                    <div class="col-md-8">{{ $antrian->hewan->jenis_hewan }}</div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">Ras</div>
                                                    <div class="col-md-8">{{ $antrian->hewan->ras }}</div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-md-4 fw-bold">Umur</div>
                                                    <div class="col-md-8">{{ $antrian->hewan->umur }} tahun</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <div class="avatar avatar-xl mb-3">
                                                    @if($antrian->hewan->foto_hewan)
                                                        <img src="{{ asset($antrian->hewan->foto_hewan) }}" alt="Pet Photo" class="img-fluid rounded">
                                                    @else
                                                        <div class="avatar bg-label-primary">
                                                            <i class="icon-base bx bx-cat fs-1"></i>
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
                    <!-- / Content -->

                    <!-- Modal Selesai & Tambah Rekam Medis -->
                    <div class="modal fade" id="completeQueueModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Rekam Medis</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.antrian.complete', $antrian->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="id_dokter" class="form-label">Pilih Dokter</label>
                                                <select class="form-select" id="id_dokter" name="id_dokter" required>
                                                    <option value="">-- Pilih Dokter --</option>
                                                    @foreach($dokters as $dokter)
                                                        <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi Pemeriksaan</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                                                    placeholder="Masukkan hasil pemeriksaan, diagnosa, dan pengobatan" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan & Selesai</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/main.js') }}"></script>

    <!-- Flash message toast -->
    @if(session('success'))
    <div class="bs-toast toast toast-placement-ex m-2 bg-success top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="icon-base bx bx-check me-2"></i>
            <div class="me-auto fw-semibold">Sukses</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{ session('success') }}</div>
    </div>
    @endif

    @if(session('error'))
    <div class="bs-toast toast toast-placement-ex m-2 bg-danger top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="icon-base bx bx-error me-2"></i>
            <div class="me-auto fw-semibold">Error</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{ session('error') }}</div>
    </div>
    @endif

    <script>
        // Mengatur toast hilang otomatis setelah 3 detik
        setTimeout(function() {
            $('.bs-toast').toast('hide');
        }, 3000);
        
        // // Konfigurasi Pusher
        // var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        //     cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        //     encrypted: true
        // });
        
        // // Subscribe ke channel 'antrian'
        // var channel = pusher.subscribe('antrian');
        
        // // Listener untuk event AntrianUpdated
        // channel.bind('App\\Events\\AntrianUpdated', function(data) {
        //     // Jika ini adalah antrian yang sedang dilihat dan statusnya berubah
        //     if (data.antrian.id == {{ $antrian->id }} && data.antrian.status != '{{ $antrian->status }}') {
        //         // Refresh halaman untuk mendapatkan informasi terbaru
        //         location.reload();
        //     }
        // });
    </script>
</body>

</html>