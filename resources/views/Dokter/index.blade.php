<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dokter List</title>
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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

                            <!-- Dokter Table -->
                            <div class="card">
                                <h5 class="card-header">Daftar Dokter</h5>

                                <!-- Button Tambah Dokter & search -->
                                <div class="d-flex justify-content-between align-items-center mx-3 mt-4 mb-3">
                                    <!-- Search kiri -->
                                    <form action="{{ route('admin.dokter.index') }}" method="GET" class="d-flex"
                                        style="max-width: 300px;">
                                        <input type="text" name="search" class="form-control me-2"
                                            placeholder="Cari dokter..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </form>

                                    <!-- Tambah Dokter kanan -->
                                    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> Tambah Dokter
                                    </a>
                                </div>

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Foto</th>
                                                <th>Nama Dokter</th>
                                                <th>Alamat</th>
                                                <th>No. Telepon</th>
                                                <th>Layanan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($dokters as $dokter)
                                                <tr>
                                                    <td>
                                                        <!-- Menampilkan foto dokter jika ada -->
                                                        @if ($dokter->foto_dokter)
                                                            <img src="{{ asset('images/dokters/' . $dokter->foto_dokter) }}"
                                                                alt="Foto Dokter" width="150">
                                                        @else
                                                            <p>No photo available</p>
                                                        @endif
                                                    </td>
                                                    <td>{{ $dokter->nama_dokter }}</td>
                                                    <td>{{ $dokter->alamat }}</td>
                                                    <td>{{ $dokter->no_telepon ?? 'No phone available' }}</td>
                                                    <td>{{ $dokter->layanan->nama_layanan ?? 'No layanan assigned' }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <!-- Tombol Lihat -->
                                                            <button type="button" class="btn btn-primary btn-sm me-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#detailModal{{ $dokter->id }}">
                                                                <i class="bi bi-eye"></i> Lihat
                                                            </button>

                                                            <!-- Tombol Edit -->
                                                            <a href="{{ route('admin.dokter.edit', $dokter->id) }}"
                                                                class="btn btn-info btn-sm me-2">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>

                                                            <!-- Tombol Delete -->
                                                            <form
                                                                action="{{ route('admin.dokter.destroy', $dokter->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal Detail Dokter -->
                                <div class="modal fade" id="detailModal{{ $dokter->id }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $dokter->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $dokter->id }}">Detail
                                                    Dokter</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>{{ $dokter->nama_dokter }}</h5>
                                                <p><strong>Alamat:</strong> {{ $dokter->alamat }}</p>
                                                <p><strong>No Telepon:</strong> {{ $dokter->no_telepon ?? 'N/A' }}</p>
                                                <p><strong>Layanan:</strong> {{ $dokter->layanan->nama_layanan ?? 'No layanan assigned' }}</p>

                                                @if ($dokter->foto_dokter)
                                                    <img src="{{ asset('images/dokters/' . $dokter->foto_dokter) }}"
                                                        alt="Foto Dokter" width="200">
                                                @else
                                                    <p>No photo available</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                {{ $dokters->links() }}
                            </div>
                            <!-- /Dokter Table -->
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
