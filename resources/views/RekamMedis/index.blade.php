<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Artikel</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Admin/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/demo.css') }}" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('Admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/config.js') }}"></script>

    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            @include('Admin.sidebar')

            <!-- Page Content -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('Admin.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">

                            <!-- Flash Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Artikel Table -->
                            <div class="card">
                                <h5 class="card-header">Rekam Medis</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nama Hewan</th>
                                                <th>Nama Dokter</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($rekamMedis as $rekam)
                                                <tr>
                                                    <td>{{ $rekam->hewan->nama_hewan }}</td> <!-- Nama Hewan -->
                                                    <td>{{ $rekam->dokter->nama_dokter }}</td> <!-- Nama Dokter -->
                                                    <td>{{ $rekam->deskripsi }}</td> <!-- Deskripsi -->
                                                    <td>{{ $rekam->tanggal }}</td> <!-- Tanggal -->
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                                        class="icon-base bx bx-edit-alt me-1"></i>
                                                                    Edit</a>
                                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                                        class="icon-base bx bx-trash me-1"></i>
                                                                    Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- /Artikel Table -->
                        </div>
                    </div>
                </div>
                <!-- /Content wrapper -->
            </div>
        </div>
        <!-- /Layout wrapper -->

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendor JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('Admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/dashboards-analytics.js') }}"></script>

    <!-- GitHub Button -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
