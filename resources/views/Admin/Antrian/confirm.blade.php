<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Konfirmasi Check-in - Zoovia</title>

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
                                                <li class="breadcrumb-item active">Konfirmasi Check-in</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Konfirmasi Check-in Antrian</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3">
                                                <div class="text-center mb-4">
                                                    <div class="avatar bg-primary p-3 mb-3">
                                                        <i class="icon-base bx bx-check-circle fs-1"></i>
                                                    </div>
                                                    <h3>Konfirmasi Check-in Antrian #{{ $antrian->nomor_antrian }}</h3>
                                                    <p class="text-muted">Verifikasi data pasien berikut sebelum melanjutkan proses</p>
                                                </div>

                                                <div class="alert alert-primary" role="alert">
                                                    <div class="d-flex">
                                                        <i class="icon-base bx bx-info-circle fs-3 me-2"></i>
                                                        <div>
                                                            <h6 class="alert-heading mb-1">Informasi Antrian</h6>
                                                            <p class="mb-0">Pastikan data berikut telah sesuai dengan pasien yang hadir.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold" width="40%">Nomor Antrian</td>
                                                                <td>: {{ $antrian->nomor_antrian }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Nama</td>
                                                                <td>: {{ $antrian->nama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Pemilik</td>
                                                                <td>: {{ $antrian->user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Hewan</td>
                                                                <td>: {{ $antrian->hewan->nama_hewan }} ({{ $antrian->hewan->jenis_hewan }} - {{ $antrian->hewan->ras }})</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Layanan</td>
                                                                <td>: {{ $antrian->layanan->nama_layanan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Keluhan</td>
                                                                <td>: {{ $antrian->keluhan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Tanggal Registrasi</td>
                                                                <td>: {{ \Carbon\Carbon::parse($antrian->created_at)->format('d F Y, H:i') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Status</td>
                                                                <td>: 
                                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="divider">
                                                    <div class="divider-text">Konfirmasi</div>
                                                </div>

                                                <form action="{{ route('admin.antrian.process', $antrian->id) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex justify-content-between mt-4">
                                                        <a href="{{ route('admin.antrian.index') }}" class="btn btn-outline-secondary">
                                                            <i class="icon-base bx bx-arrow-back me-1"></i> Kembali
                                                        </a>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="icon-base bx bx-check me-1"></i> Konfirmasi Check-in
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

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
    </script>
</body>

</html>