<!doctype html>
<html lang="id" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Tambah Artikel</title>
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
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    
    <!-- Tambahkan gaya kustom -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <!-- Wrapper Layout -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar Menu -->
            @include('Admin.sidebar')

            <!-- Container Layout -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('Admin.navbar')

                <!-- Wrapper Konten -->
                <div class="content-wrapper">
                    <!-- Konten -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="card">
                                <h5 class="card-header">Tambah Artikel</h5>

                                <div class="card-body">
                                    <!-- Form untuk menambah artikel -->
                                    <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul Artikel</label>
                                            <input type="text" class="form-control" id="judul" name="judul" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label for="penulis" class="form-label">Penulis</label>
                                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label for="thumbnail" class="form-label">Thumbnail</label>
                                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                                    </form>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Wrapper Konten -->
            </div>
        </div>
        <!-- / Wrapper Layout -->

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- JS Core -->
    <script src="{{ asset('Admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/menu.js') }}"></script>

    <!-- JS Vendor -->
    <script src="{{ asset('Admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- JS Utama -->
    <script src="{{ asset('Admin/assets/js/main.js') }}"></script>

    <!-- JS Halaman -->
    <script src="{{ asset('Admin/assets/js/dashboards-analytics.js') }}"></script>
</body>

</html>
