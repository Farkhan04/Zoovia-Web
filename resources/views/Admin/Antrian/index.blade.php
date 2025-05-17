<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Kelola Antrian - Zoovia</title>

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
                        <!-- Header -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="fw-bold mb-0">Kelola Antrian</h4>
                                            <div>
                                                <a href="{{ route('admin.antrian.scan') }}" class="btn btn-primary me-2">
                                                    <i class="icon-base bx bx-qr-scan me-1"></i> Scan Barcode
                                                </a>
                                                <a href="{{ route('admin.antrian.callnext') }}" class="btn btn-success">
                                                    <i class="icon-base bx bx-user-voice me-1"></i> Panggil Antrian
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter dan Tanggal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('admin.antrian.index') }}" method="GET" class="row g-3">
                                            <div class="col-md-6">
                                                <label for="date" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="date" name="date" value="{{ $date ?? now()->toDateString() }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="">Semua Status</option>
                                                    <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="diproses" {{ $status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Antrian -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h5 class="card-title mb-1">Total Antrian</h5>
                                                <h2 class="fw-bold mb-0" id="total-antrian">{{ $summary->total ?? 0 }}</h2>
                                            </div>
                                            <div class="avatar bg-label-primary p-2">
                                                <i class="icon-base bx bx-list-ul"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h5 class="card-title mb-1">Menunggu</h5>
                                                <h2 class="fw-bold mb-0 text-warning" id="waiting-antrian">{{ $summary->waiting ?? 0 }}</h2>
                                            </div>
                                            <div class="avatar bg-label-warning p-2">
                                                <i class="icon-base bx bx-time-five"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h5 class="card-title mb-1">Diproses</h5>
                                                <h2 class="fw-bold mb-0 text-info" id="processing-antrian">{{ $summary->processing ?? 0 }}</h2>
                                            </div>
                                            <div class="avatar bg-label-info p-2">
                                                <i class="icon-base bx bx-loader"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h5 class="card-title mb-1">Selesai</h5>
                                                <h2 class="fw-bold mb-0 text-success" id="completed-antrian">{{ $summary->completed ?? 0 }}</h2>
                                            </div>
                                            <div class="avatar bg-label-success p-2">
                                                <i class="icon-base bx bx-check-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Antrian Saat Ini -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="m-0 me-2 card-title">Antrian Saat Ini</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($currentQueue)
                                            <div class="current-queue-container">
                                                <h1 class="display-1 fw-bold text-primary" id="current-number">{{ $currentQueue->nomor_antrian }}</h1>
                                                <h5 class="mb-3" id="current-name">{{ $currentQueue->nama }}</h5>
                                                <div class="badge bg-info fs-6 mb-3">Sedang Diproses</div>
                                                <p><strong>Layanan:</strong> <span id="current-service">{{ $currentQueue->layanan->nama_layanan }}</span></p>
                                            </div>
                                        @else
                                            <div class="py-4 text-muted">
                                                <i class="icon-base bx bx-info-circle fs-1"></i>
                                                <h5 class="mt-2">Tidak ada antrian yang sedang diproses</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="m-0 me-2 card-title">Antrian Berikutnya</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($nextQueue)
                                            <div class="next-queue-container">
                                                <h1 class="display-1 fw-bold text-warning" id="next-number">{{ $nextQueue->nomor_antrian }}</h1>
                                                <h5 class="mb-3" id="next-name">{{ $nextQueue->nama }}</h5>
                                                <div class="badge bg-warning text-dark fs-6 mb-3">Menunggu</div>
                                                <p><strong>Layanan:</strong> <span id="next-service">{{ $nextQueue->layanan->nama_layanan }}</span></p>
                                            </div>
                                        @else
                                            <div class="py-4 text-muted">
                                                <i class="icon-base bx bx-info-circle fs-1"></i>
                                                <h5 class="mt-2">Tidak ada antrian yang menunggu</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Antrian -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Daftar Antrian</h5>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Antrian</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Nama Hewan</th>
                                            <th>Layanan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" id="antrian-table-body">
                                        @if(count($antrian) > 0)
                                            @foreach($antrian as $index => $item)
                                                <tr data-id="{{ $item->id }}" class="antrian-row">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $item->nomor_antrian }}</strong></td>
                                                    <td>{{ $item->user->name }}</td>
                                                    <td>{{ $item->hewan->nama_hewan }}</td>
                                                    <td>{{ $item->layanan->nama_layanan }}</td>
                                                    <td>
                                                        @if($item->status == 'menunggu')
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @elseif($item->status == 'diproses')
                                                            <span class="badge bg-info">Diproses</span>
                                                        @else
                                                            <span class="badge bg-success">Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="{{ route('admin.antrian.show', $item->id) }}" class="btn btn-sm btn-primary me-2">
                                                                <i class="icon-base bx bx-show"></i>
                                                            </a>
                                                            @if($item->status == 'menunggu')
                                                                <a href="{{ route('admin.antrian.confirm', $item->id) }}" class="btn btn-sm btn-warning">
                                                                    <i class="icon-base bx bx-check-square"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center py-3">Tidak ada data antrian</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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

        // Konfigurasi Pusher
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            encrypted: true
        });
        
        // Subscribe ke channel 'antrian'
        var channel = pusher.subscribe('antrian');
        
        // Listener untuk event AntrianUpdated
        channel.bind('App\\Events\\AntrianUpdated', function(data) {
            // Update data statistik
            updateQueueStatistics(data.queueSummary);
            
            // Update antrian saat ini dan berikutnya
            updateCurrentQueues(data);
            
            // Refresh daftar antrian jika perlu
            if (data.action === 'create' || data.action === 'update-status') {
                refreshQueueList();
            }
            
            // Notifikasi toast
            if (data.action === 'create') {
                showToast('success', 'Antrian baru telah ditambahkan.');
            } else if (data.action === 'update-status') {
                showToast('info', 'Status antrian telah diperbarui.');
            }
        });
        
        // Fungsi untuk update statistik antrian
        function updateQueueStatistics(summary) {
            $('#total-antrian').text(summary.total || 0);
            $('#waiting-antrian').text(summary.waiting || 0);
            $('#processing-antrian').text(summary.processing || 0);
            $('#completed-antrian').text(summary.completed || 0);
        }
        
        // Fungsi untuk update antrian saat ini dan berikutnya
        function updateCurrentQueues(data) {
            // Update antrian yang sedang diproses
            if (data.queueSummary.current_number > 0) {
                $('.current-queue-container').removeClass('d-none');
                $('#current-number').text(data.queueSummary.current_number);
                
                // Cari data antrian yang sedang diproses
                if (data.action === 'update-status' && data.antrian.status === 'diproses') {
                    $('#current-name').text(data.antrian.nama);
                    $('#current-service').text(data.antrian.layanan.nama_layanan);
                }
            } else {
                $('.current-queue-container').addClass('d-none');
            }
            
            // Update antrian berikutnya
            if (data.queueSummary.next_number > 0) {
                $('.next-queue-container').removeClass('d-none');
                $('#next-number').text(data.queueSummary.next_number);
                
                // Cek jika antrian yang sedang diproses sekarang adalah yang sebelumnya menunggu
                if (data.action === 'update-status' && data.antrian.status === 'diproses') {
                    // Kita perlu mengupdate UI dengan antrian menunggu berikutnya
                    refreshQueueList();
                }
            } else {
                $('.next-queue-container').addClass('d-none');
            }
        }
        
        // Fungsi untuk refresh daftar antrian
        function refreshQueueList() {
            // Gunakan AJAX untuk memuat ulang daftar antrian
            $.ajax({
                url: window.location.href,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    var newHtml = $(response).find('#antrian-table-body').html();
                    $('#antrian-table-body').html(newHtml);
                }
            });
        }
        
        // Fungsi untuk menampilkan toast
        function showToast(type, message) {
            var bgClass = type === 'success' ? 'bg-success' : type === 'info' ? 'bg-info' : 'bg-danger';
            var icon = type === 'success' ? 'bx-check' : type === 'info' ? 'bx-info-circle' : 'bx-error';
            
            var toast = `
                <div class="bs-toast toast toast-placement-ex m-2 ${bgClass} top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="icon-base bx ${icon} me-2"></i>
                        <div class="me-auto fw-semibold">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>
            `;
            
            $('body').append(toast);
            
            setTimeout(function() {
                $('.bs-toast').toast('hide');
            }, 3000);
        }
    </script>
</body>

</html>