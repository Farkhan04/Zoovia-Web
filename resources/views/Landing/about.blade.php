<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Zoovia Puskeswan-Web </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ 'Landing/assets/img/favicon.ico' }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ 'Landing/assets/css/bootstrap.min.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/owl.carousel.min.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/slicknav.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/flaticon.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/gijgo.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/animate.min.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/animated-headline.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/magnific-popup.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/fontawesome-all.min.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/themify-icons.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/slick.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/nice-select.css' }}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/style.css' }}">
</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ 'Landing/assets/img/logo/lozoovia.png' }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!--? Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="index"><img src="{{ 'Landing/assets/img/logo/logozoovia.png' }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="index">Home</a></li>
                                            <li><a href="#">About</a></li>
                                            <li><a href="dokter">Dokter</a></li>
                                            <li><a href="pelayanan">Pelayanan</a></li>

                                        </ul>
                                    </nav>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                    <a href="login" class="btn header-btn">Login</a>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <!--? Hero Start -->
        <div class="slider-area2">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 text-center">
                                <h2>Tentang Kami</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->

        <div class="jadwal-area section-padding30">
            <div class="container">
                <!-- Section Title -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-tittle text-center mb-100">
                            <span>Layanan Puskeswan Kami</span>
                            <h2>Jadwal Layanan</h2>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Layanan Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered"
                            style="width: 100%; font-size: 1.5rem; padding: 15px; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th scope="col" style="padding: 20px; text-align: center;">Nama Layanan</th>
                                    <th scope="col" style="padding: 20px; text-align: center;">Jam Buka</th>
                                    <th scope="col" style="padding: 20px; text-align: center;">Jam Tutup</th>
                                    <th scope="col" style="padding: 20px; text-align: center;">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($layanan as $service)
                                    <tr style="text-align: center;">
                                        <td style="padding: 20px;">{{ $service->nama_layanan }}</td>
                                        <td style="padding: 20px;">
                                            {{ \Carbon\Carbon::parse($service->jam_operasional_mulai)->format('H:i') }}</td>
                                        <td style="padding: 20px;">
                                            {{ \Carbon\Carbon::parse($service->jam_operasional_selesai)->format('H:i') }}
                                        </td>
                                        <td style="padding: 20px;">{{ Str::limit($service->deskripsi_layanan, 100) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <!--? Gallery Area Start -->
        <div class="gallery-area section-padding30">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-tittle text-center mb-100">
                            <span>Galeri Kami</span>
                            <h2>Galeri Puskeswan Nganjuk</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Left -->
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="single-gallery mb-30">
                                    <div class="gallery-img big-img"
                                        style="background-image: url(Landing/assets/img/gallery/galeri1.webp);"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="single-gallery mb-30">
                                    <div class="gallery-img small-img"
                                        style="background-image: url(Landing/assets/img/gallery/galeri2.jpg);"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="single-gallery mb-30">
                                    <div class="gallery-img small-img"
                                        style="background-image: url(Landing/assets/img/gallery/galeri3.webp);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right -->
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="single-gallery mb-30">
                                    <div class="gallery-img small-img"
                                        style="background-image: url(Landing/assets/img/gallery/galeri4.webp);"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="single-gallery mb-30">
                                    <div class="gallery-img small-img"
                                        style="background-image: url(Landing/assets/img/gallery/galeri5.webp);"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="single-gallery mb-30">
                                    <div class="gallery-img big-img"
                                        style="background-image: url(Landing/assets/img/gallery/galeri6.jpg);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery Area End -->
        <!--? gallery Products Start -->
        <div class="gallery-area fix">
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="gallery-box">
                            <div class="single-gallery">
                                <div class="gallery-img "
                                    style="background-image: url({{"Landing/assets/img/gallery/gallery1.png"}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="gallery-box">
                            <div class="single-gallery">
                                <div class="gallery-img "
                                    style="background-image: url({{"Landing/assets/img/gallery/gallery2.png"}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="gallery-box">
                            <div class="single-gallery">
                                <div class="gallery-img "
                                    style="background-image: url({{"Landing/assets/img/gallery/gallery3.png"}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="gallery-box">
                            <div class="single-gallery">
                                <div class="gallery-img "
                                    style="background-image: url({{ 'Landing/assets/img/gallery/gallery4.png' }});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="gallery-box">
                            <div class="single-gallery">
                                <div class="gallery-img "
                                    style="background-image: url({{"Landing/assets/img/gallery/gallery5.png"}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="gallery-box">
                            <div class="single-gallery">
                                <div class="gallery-img "
                                    style="background-image: url({{"Landing/assets/img/gallery/gallery6.png"}});">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- gallery Products End -->
        <!--? Team Start -->
        <div class="team-area section-padding30">
            <div class="container" id="dokter-section">
                <!-- Section Tittle -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-tittle text-center mb-100">
                            <span>Dokter Kami</span>
                            <h2>Spesialis Kami</h2>
                        </div>
                    </div>
                </div>
                <!-- Display doctors data -->
                <div class="doctors d-flex flex-row flex-wrap">
                    @foreach($doctors as $doctor)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <!-- Doctor Card -->
                            <div class="card">
                                <!-- Card Image -->
                                <img src="{{ asset('storage/' . $doctor->foto_dokter) }}" alt="{{ $doctor->nama_dokter }}"
                                    class="card-img-top" style="max-height: 250px; object-fit: cover;">

                                <!-- Card Body -->
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $doctor->nama_dokter }}</h5>
                                    <p class="card-text text-muted">{{ $doctor->layanan->nama_layanan }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Team End -->
    </main>
    <footer>
        <!--? Footer Start-->
        <div class="footer-area section-bg" data-background="{{ 'Landing/assets/img/gallery/footer_bg.jpg' }}">
            <div class="container">
                <div class="footer-top footer-padding">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-8">
                            <div class="single-footer-caption mb-50">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="index"><img src="{{ 'Landing/assets/img/logo/logozoovia_footer.png' }}"
                                            alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4> About US</h4>
                                    <div class="footer-pera">
                                        <p class="info1">Kami menyediakan layanan kesehatan hewan terbaik untuk hewan
                                            peliharaan. </p>
                                        <p class="info1">Hubungi kontak kami dibawah ini.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-number mb-50">
                                    <h4><span>+62 </span>85 257 625 557</h4>
                                    <p>youremail@gmail.com</p>
                                </div>
                                <!-- Form -->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-9 col-lg-8">
                            <div class="footer-copy-right">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script> All rights reserved | This template is made with <i class="fa fa-heart"
                                        aria-hidden="true"></i> by <a href="https://colorlib.com"
                                        target="_blank">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4">
                            <!-- Footer Social -->
                            <div class="footer-social f-right">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fas fa-globe"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->

    <script src="./{{ 'Landing/assets/js/vendor/modernizr-3.5.0.min.js' }}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./{{ 'Landing/assets/js/vendor/jquery-1.12.4.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/popper.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/bootstrap.min.js' }}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./{{ 'Landing/assets/js/jquery.slicknav.min.js' }}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./{{ 'Landing/assets/js/owl.carousel.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/slick.min.js' }}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./{{ 'Landing/assets/js/wow.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/animated.headline.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/jquery.magnific-popup.js' }}"></script>

    <!-- Date Picker -->
    <script src="./{{ 'Landing/assets/js/gijgo.min.js' }}"></script>
    <!-- Nice-select, sticky -->
    <script src="./{{ 'Landing/assets/js/jquery.nice-select.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/jquery.sticky.js' }}"></script>

    <!-- counter , waypoint -->
    <script src="./{{ 'Landing/assets/js/jquery.counterup.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/waypoints.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/jquery.countdown.min.js' }}"></script>
    <!-- contact js -->
    <script src="./{{ 'Landing/assets/js/contact.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/jquery.form.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/jquery.validate.min.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/mail-script.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/jquery.ajaxchimp.min.js' }}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./{{ 'Landing/assets/js/plugins.js' }}"></script>
    <script src="./{{ 'Landing/assets/js/main.js' }}"></script>

</body>

</html>