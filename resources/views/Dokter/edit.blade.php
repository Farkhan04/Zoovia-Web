<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Dokter Zoovia</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Admin/assets/img/favicon/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/demo.css') }}" />
    
    <script src="{{ asset('Admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/config.js') }}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar Menu -->
            @include('Admin.sidebar')

            <div class="layout-page">
                <!-- Navbar -->
                @include('Admin.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header">Edit Dokter</h5>
                                    <div class="card-body">
                                        <!-- Form edit dokter -->
                                        <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="nama_dokter" class="form-label">Nama Dokter</label>
                                                <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $dokter->nama_dokter) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $dokter->alamat) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $dokter->no_telepon) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="layanan" class="form-label">Layanan</label>
                                                <input type="text" class="form-control" id="layanan" name="layanan" value="{{ old('layanan', $dokter->layanan->nama_layanan ?? '') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="foto_dokter" class="form-label">Foto Dokter</label>
                                                <input type="file" class="form-control" id="foto_dokter" name="foto_dokter">
                                                @if($dokter->foto_dokter)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('images/dokters/'.$dokter->foto_dokter) }}" alt="Foto Dokter" width="100">
                                                    </div>
                                                @endif
                                            </div>

                                            <button type="submit" class="btn btn-primary">Perbarui Dokter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('Admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('Admin/assets/js/dashboards-analytics.js') }}"></script>
</body>
</html>
