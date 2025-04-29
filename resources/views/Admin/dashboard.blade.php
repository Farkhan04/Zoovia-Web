<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ 'Admin/assets/' }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard: Zoovia</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ 'Admin/assets/img/favicon/favicon.ico' }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/fonts/iconify-icons.css' }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/css/core.css' }}" />
    <link rel="stylesheet" href="{{ 'Admin/assets/css/demo.css' }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css' }}" />

    <!-- endbuild -->

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/libs/apex-charts/apex-charts.css' }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ 'Admin/assets/vendor/js/helpers.js' }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ 'Admin/assets/js/config.js' }}"></script>
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

                <!-- Include Navbar -->
                @include('Admin.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xxl-8 mb-6 order-0">

                            </div>
                            <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between mb-4">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ 'Admin/assets/img/icons/unicons/chart-success.png' }}"
                                                            alt="chart success" class="rounded" />
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="cardOpt3"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i
                                                                class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="cardOpt3">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                More</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mb-1">Kelola Antrian</p>
                                                <h4 class="card-title mb-3">$12,628</h4>
                                                <small class="text-success fw-medium"><i
                                                        class="icon-base bx bx-up-arrow-alt"></i> +72.80%</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between mb-4">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ 'Admin/assets/img/icons/unicons/wallet-info.png' }}"
                                                            alt="wallet info" class="rounded" />
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="cardOpt6"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i
                                                                class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="cardOpt6">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                More</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mb-1">Antrian Hari Ini</p>
                                                <h4 class="card-title mb-3">$4,679</h4>
                                                <small class="text-success fw-medium"><i
                                                        class="icon-base bx bx-up-arrow-alt"></i> +28.42%</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--/ Total Revenue -->
                            <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2 profile-report">
                                <div class="row">
                                    <div class="col-6 mb-6 payments">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between mb-4">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ 'Admin/assets/img/icons/unicons/paypal.png' }}"
                                                            alt="paypal" class="rounded" />
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="cardOpt4"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i
                                                                class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="cardOpt4">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                More</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mb-1">Antrian Selesai</p>
                                                <h4 class="card-title mb-3">$2,456</h4>
                                                <small class="text-danger fw-medium"><i
                                                        class="icon-base bx bx-down-arrow-alt"></i> -14.82%</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-6 transactions">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div
                                                    class="card-title d-flex align-items-start justify-content-between mb-4">
                                                    <div class="avatar flex-shrink-0">
                                                        <img src="{{ 'Admin/assets/img/icons/unicons/cc-primary.png' }}"
                                                            alt="Credit Card" class="rounded" />
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="cardOpt1"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i
                                                                class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                            <a class="dropdown-item" href="javascript:void(0);">View
                                                                More</a>
                                                            <a class="dropdown-item"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mb-1">Transactions</p>
                                                <h4 class="card-title mb-3">$14,857</h4>
                                                <small class="text-success fw-medium"><i
                                                        class="icon-base bx bx-up-arrow-alt"></i> +28.14%</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl">
                                <div
                                    class="footer-container d-flex align-items-center justify-content-center py-4 flex-md-row flex-column">
                                    <div class="mb-2 mb-md-0 text-center">
                                        &#169;
                                        <script>
                                            document.write(new Date().getFullYear());
                                        </script>
                                        , Zoovia
                                    </div>
                                </div>
                            </div>

                        </footer>
                        <!-- / Footer -->

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

        <script src="{{ 'Admin/assets/vendor/libs/jquery/jquery.js' }}"></script>

        <script src="{{ 'Admin/assets/vendor/libs/popper/popper.js' }}"></script>
        <script src="{{ 'Admin/assets/vendor/js/bootstrap.js' }}"></script>

        <script src="{{ 'Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js' }}"></script>

        <script src="{{ 'Admin/assets/vendor/js/menu.js' }}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ 'Admin/assets/vendor/libs/apex-charts/apexcharts.js' }}"></script>

        <!-- Main JS -->

        <script src="{{ 'Admin/assets/js/main.js' }}"></script>

        <!-- Page JS -->
        <script src="{{ 'Admin/assets/js/dashboards-analytics.js' }}"></script>

        <!-- Place this tag before closing body tag for github widget button. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
