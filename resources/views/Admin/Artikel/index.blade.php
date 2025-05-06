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
                                <h5 class="card-header">Artikel List</h5>

                                <!-- Button Tambah Artikel & search -->
                                <div class="d-flex justify-content-between align-items-center mx-3 mt-4 mb-3">
                                    <!-- Search kiri -->
                                    <form action="{{ route('artikel.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                                        <input type="text" name="search" class="form-control me-2" placeholder="Cari artikel..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </form>
                                
                                    <!-- Tambah Artikel kanan -->
                                    <a href="{{ route('artikel.create') }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> Tambah Artikel
                                    </a>
                                </div>
                                


                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Thumbnail</th>
                                                <th>Judul</th>
                                                <th>Deskripsi</th>
                                                <th>Penulis</th>
                                                <th>Tanggal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($artikels as $artikel)
                                                <tr>
                                                    <td>
                                                        <!-- Menampilkan thumbnail jika ada -->
                                                        @if ($artikel->thumbnail)
                                                            <img src="{{ asset('storage/thumbnails/' . $artikel->thumbnail) }}" alt="Thumbnail" width="150">
                                                        @else
                                                            <p>No thumbnail available</p>
                                                        @endif
                                                    </td>
                                                    <td>{{ $artikel->judul }}</td>
                                                    <td class="truncate" title="{{ $artikel->deskripsi }}">
                                                        {{ \Illuminate\Support\Str::limit($artikel->deskripsi, 100, '...') }}
                                                        <a href="{{ route('artikel.show', $artikel->id) }}"
                                                            class="text-primary">Baca lebih</a>
                                                    </td>
                                                    <td>{{ $artikel->penulis }}</td>
                                                    <td>{{ $artikel->tanggal }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('artikel.edit', $artikel->id) }}">
                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                </a>
                                                                <form
                                                                    action="{{ route('artikel.destroy', $artikel->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item"
                                                                        onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                                                                        <i class="bx bx-trash me-1"></i> Delete
                                                                    </button>
                                                                </form>
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
