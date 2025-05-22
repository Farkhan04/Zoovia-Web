<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" data-assets-path="{{ asset('Admin/assets/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Zoovia - Klinik Hewan')">
    <meta name="keywords" content="klinik hewan, dokter hewan, layanan hewan, zoovia">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Zoovia Admin</title>

    <!-- Favicon -->
    <link type="image" href="{{asset('storage/logo.svg')}}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/fonts/iconify-icons.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/demo.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/custom.css') }}">

    @stack('styles')

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
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between py-3">
                                <div class="mb-2 mb-md-0">
                                    &copy; {{ date('Y') }} <a href="#" class="footer-link fw-semibold">Zoovia</a>. Klinik Hewan Terpercaya.
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content wrapper -->
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

    <!-- Vendors JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('Admin/assets/js/main.js') }}"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle menu on mobile
            $('#layout-menu-toggle').on('click', function() {
                $('body').toggleClass('layout-menu-expanded');
                $('#layout-menu-overlay').fadeToggle();
            });
            
            // Close menu when clicking on overlay
            $('#layout-menu-overlay').on('click', function() {
                $('body').removeClass('layout-menu-expanded');
                $(this).fadeOut();
            });

            // Auto hide alert after 5 seconds
            setTimeout(function() {
                $('.alert-dismissible').alert('close');
            }, 5000);
            
            // Dropdown menu positioning
            $('.dropdown-toggle').on('click', function() {
                // Check if the dropdown menu would go off-screen
                setTimeout(function() {
                    $('.dropdown-menu.show').each(function() {
                        const $menu = $(this);
                        const menuRight = $menu.offset().left + $menu.outerWidth();
                        const windowWidth = $(window).width();
                        
                        if (menuRight > windowWidth) {
                            $menu.addClass('dropdown-menu-end');
                        }
                    });
                }, 10);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>