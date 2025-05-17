<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Scan Barcode - Zoovia</title>

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
    <style>
        #scanner-container {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 10px;
            background-color: #000;
            position: relative;
        }
        
        #scanner-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        #scanner-container canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .camera-guides {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }
        
        .guide-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: #fff;
            border-style: solid;
            border-width: 0;
        }
        
        .top-left {
            top: 40px;
            left: 40px;
            border-left-width: 4px;
            border-top-width: 4px;
        }
        
        .top-right {
            top: 40px;
            right: 40px;
            border-right-width: 4px;
            border-top-width: 4px;
        }
        
        .bottom-left {
            bottom: 40px;
            left: 40px;
            border-left-width: 4px;
            border-bottom-width: 4px;
        }
        
        .bottom-right {
            bottom: 40px;
            right: 40px;
            border-right-width: 4px;
            border-bottom-width: 4px;
        }
        
        .scan-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.8);
            animation: scan 2s linear infinite;
        }
        
        @keyframes scan {
            0% {
                top: 40px;
            }
            50% {
                top: calc(100% - 40px);
            }
            100% {
                top: 40px;
            }
        }
        
        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 5;
        }
        
        .scanner-window {
            position: absolute;
            top: 40px;
            left: 40px;
            right: 40px;
            bottom: 40px;
            background-color: transparent;
            z-index: 6;
        }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('Admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/assets/js/config.js') }}"></script>
    
    <!-- QR Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
                                                <li class="breadcrumb-item active">Scan Barcode</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Scan Barcode -->
                            <div class="col-lg-8 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Scan Barcode Antrian</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info" role="alert">
                                            <div class="d-flex">
                                                <i class="icon-base bx bx-info-circle fs-3 me-2"></i>
                                                <div>
                                                    <h6 class="alert-heading mb-1">Petunjuk Scan</h6>
                                                    <p class="mb-0">Arahkan kamera ke barcode atau QR code antrian. Sistem akan otomatis mendeteksi dan melakukan check-in.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-4">
                                            <div id="scanner-container" class="mx-auto">
                                                <div id="reader"></div>
                                                <div class="camera-guides">
                                                    <div class="scanner-overlay"></div>
                                                    <div class="scanner-window"></div>
                                                    <div class="guide-corner top-left"></div>
                                                    <div class="guide-corner top-right"></div>
                                                    <div class="guide-corner bottom-left"></div>
                                                    <div class="guide-corner bottom-right"></div>
                                                    <div class="scan-line"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between mt-4">
                                            <button id="stopScanBtn" class="btn btn-outline-danger d-none">
                                                <i class="icon-base bx bx-stop-circle me-1"></i> Stop Scan
                                            </button>
                                            <button id="startScanBtn" class="btn btn-primary">
                                                <i class="icon-base bx bx-scan me-1"></i> Mulai Scan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Manual Input -->
                            <div class="col-lg-4 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Input Manual</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Jika scan barcode tidak berfungsi, Anda dapat memasukkan ID antrian secara manual:</p>

                                        <form action="{{ route('admin.antrian.search') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="search" class="form-label">ID Antrian / Nomor Antrian</label>
                                                <input type="text" class="form-control" id="search" name="search" 
                                                    placeholder="Masukkan ID atau nomor antrian" required>
                                                @error('search')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="icon-base bx bx-search me-1"></i> Cari Antrian
                                            </button>
                                        </form>

                                        <div class="divider my-4">
                                            <div class="divider-text">Atau</div>
                                        </div>

                                        <a href="{{ route('admin.antrian.index') }}" class="btn btn-outline-secondary w-100">
                                            <i class="icon-base bx bx-arrow-back me-1"></i> Kembali ke Daftar Antrian
                                        </a>
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
        
        // Variabel untuk QR Scanner
        let html5QrcodeScanner = null;
        
        // Setup QR Scanner
        function startScanner() {
            if (html5QrcodeScanner === null) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", 
                    { 
                        fps: 10, 
                        qrbox: {width: 250, height: 250},
                        rememberLastUsedCamera: true,
                        showTorchButtonIfSupported: true
                    }
                );
            }
            
            // Callback ketika QR terdeteksi
            function onScanSuccess(decodedText, decodedResult) {
                // Menghentikan scanner setelah berhasil menscan
                html5QrcodeScanner.clear();
                html5QrcodeScanner = null;
                
                // Tampilkan indikator loading
                $('#startScanBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');
                $('#startScanBtn').prop('disabled', true);
                
                // Redirect ke halaman check-in
                window.location.href = "{{ route('admin.antrian.confirm', '') }}/" + decodedText;
            }
            
            // Mulai scanner
            html5QrcodeScanner.render(onScanSuccess);
            
            // Update UI
            $('#startScanBtn').addClass('d-none');
            $('#stopScanBtn').removeClass('d-none');
        }
        
        // Hentikan scanner
        function stopScanner() {
            if (html5QrcodeScanner !== null) {
                html5QrcodeScanner.clear();
                html5QrcodeScanner = null;
                
                // Update UI
                $('#stopScanBtn').addClass('d-none');
                $('#startScanBtn').removeClass('d-none');
            }
        }
        
        // Event Listeners
        $(document).ready(function() {
            $('#startScanBtn').on('click', startScanner);
            $('#stopScanBtn').on('click', stopScanner);
        });
    </script>
</body>

</html>