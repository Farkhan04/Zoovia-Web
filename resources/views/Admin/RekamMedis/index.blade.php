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

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

</head>

<body>

    <!-- Menambahkan CDN jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Menambahkan CDN Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

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
                            <!-- Tabel Rekam Medis -->
                            <div class="card mt-3">
                                <!-- In your blade template, replace the current filter buttons with this code -->
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Rekam Medis</h5>

                                    <!-- Filter Buttons with Active State -->
                                    <div>
                                        <a href="{{ route('admin.rekammedis.index', ['status' => 'diproses']) }}"
                                            class="btn {{ request('status') == 'diproses' || request('status') == null ? 'btn-primary' : 'btn-outline-primary' }}">
                                            Diproses
                                            @if (request('status') == 'diproses' || request('status') == null)
                                                <i class="bi bi-check-circle-fill ms-1"></i>
                                            @endif
                                        </a>
                                        <a href="{{ route('admin.rekammedis.index', ['status' => 'selesai']) }}"
                                            class="btn {{ request('status') == 'selesai' ? 'btn-success' : 'btn-outline-success' }}">
                                            Selesai
                                            @if (request('status') == 'selesai')
                                                <i class="bi bi-check-circle-fill ms-1"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                                <!--  Form Pencarian  -->
                                <!-- Search kiri -->
                                <form action="{{ route('admin.artikel.index') }}" method="GET" class="d-flex"
                                    style="max-width: 300px; margin: 20px;">
                                    <input type="text" name="search" class="form-control me-2"
                                        placeholder="Cari artikel..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </form>

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nama Hewan</th>
                                                <th>Nama Dokter</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <!-- Find this section in your blade template file -->
                                            @foreach ($rekamMedis as $rekam)
                                                <tr>
                                                    <td>{{ $rekam->hewan->nama_hewan }}</td>
                                                    <td>{{ $rekam->dokter->nama_dokter }}</td>
                                                    <td>{{ $rekam->deskripsi }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($rekam->tanggal)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $rekam->antrian->status }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <!-- Edit Button -->
                                                            <a href="#" class="btn btn-info btn-sm me-2"
                                                                onclick="editRekam('{{ $rekam->id }}', '{{ $rekam->deskripsi }}', '{{ \Carbon\Carbon::parse($rekam->tanggal)->format('Y-m-d') }}')"
                                                                data-bs-toggle="modal" data-bs-target="#editModal">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>

                                                            <!-- Delete Button -->
                                                            <form
                                                                action="{{ route('admin.rekammedis.destroy', $rekam->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                            </div>
                            <!-- /Artikel Table -->

                            <!-- Modal Edit Rekam Medis -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Rekam Medis</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.rekammedis.update', 'id') }}" method="POST"
                                            id="editForm">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" id="tanggal"
                                                        class="form-control" required>
                                                </div>
                                                <input type="hidden" name="rekam_id" id="rekam_id">
                                            </div>
                                            <div class="modal-footer">
                                                <!-- Make sure both attributes are included for maximum compatibility -->
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal" data-dismiss="modal"
                                                    id="btnCancelModal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Add this JavaScript at the end of your file, just before the closing </body> tag -->
                            <script>
                                // Function to handle edit rekam medis
                                function editRekam(id, deskripsi, tanggal) {
                                    document.getElementById('rekam_id').value = id;
                                    document.getElementById('deskripsi').value = deskripsi;
                                    document.getElementById('tanggal').value = tanggal;
                                    document.getElementById('editForm').action = '{{ route('admin.rekammedis.update', ':id') }}'.replace(':id',
                                        id);
                                }

                                // Extra JavaScript to ensure modal closes properly
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Get the cancel button
                                    const btnCancel = document.getElementById('btnCancelModal');

                                    // Add click event listener to manually hide the modal
                                    if (btnCancel) {
                                        btnCancel.addEventListener('click', function() {
                                            // Try Bootstrap 5 way
                                            const modalElement = document.getElementById('editModal');
                                            if (modalElement) {
                                                // Try using Bootstrap 5 modal instance
                                                try {
                                                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                                                    if (modalInstance) {
                                                        modalInstance.hide();
                                                    }
                                                } catch (error) {
                                                    console.log('Bootstrap 5 modal instance not found');
                                                }

                                                // Try using jQuery if available (Bootstrap 4 way)
                                                if (typeof jQuery !== 'undefined') {
                                                    try {
                                                        jQuery('#editModal').modal('hide');
                                                    } catch (error) {
                                                        console.log('jQuery modal hide failed');
                                                    }
                                                }

                                                // As a last resort, try to hide using classes directly
                                                modalElement.classList.remove('show');
                                                modalElement.style.display = 'none';

                                                // Remove modal backdrop if exists
                                                const backdrops = document.querySelectorAll('.modal-backdrop');
                                                backdrops.forEach(backdrop => {
                                                    backdrop.remove();
                                                });

                                                // Remove modal-open class from body
                                                document.body.classList.remove('modal-open');
                                            }
                                        });
                                    }
                                });
                            </script>
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
