<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Zoovia Puskeswan-Web </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ 'Landing/assets/img/favicon.ico'}}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ 'Landing/assets/css/bootstrap.min.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/owl.carousel.min.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/slicknav.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/flaticon.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/gijgo.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/animate.min.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/animated-headline.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/magnific-popup.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/fontawesome-all.min.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/themify-icons.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/slick.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/nice-select.css'}}">
    <link rel="stylesheet" href="{{ 'Landing/assets/css/style.css'}}">
</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ 'Landing/assets/img/logo/lozoovia.png'}}" alt="">
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
                                <a href="index"><img src="{{ 'Landing/assets/img/logo/logozoovia.png'}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="index">Home</a></li>
                                            <li><a href="about">About</a></li>
                                            <li><a href="dokter">Dokter</a></li>
                                            <li><a href="#">Pelayanan</a></li>
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
                                <h2>Pelayanan</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        <!--? department_area_start  -->
        <div class="department_area section-padding2">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center mb-100">
                            <span>Puskeswan Kami</span>
                            <h2>Layanan Kami</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="depart_ment_tab mb-30">
                            <!-- Tabs Buttons -->
                            <ul class="nav" id="myTab" role="tablist">
                                @foreach($layanan as $service)
                                    <li class="nav-item">
                                        <a class="nav-link" id="service-{{ $service->id }}-tab" data-toggle="tab"
                                            href="#service-{{ $service->id }}" role="tab"
                                            aria-controls="service-{{ $service->id }}" aria-selected="false">
                                            <i class="{{ $service->icon }}"></i>
                                            <h4>{{ $service->nama_layanan }}</h4>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="dept_main_info white-bg">
                    <div class="tab-content" id="myTabContent">
                        @foreach($layanan as $index => $service)
                            <div class="tab-pane fade @if($index == 1) show active @endif" id="service-{{ $service->id }}"
                                role="tabpanel" aria-labelledby="service-{{ $service->id }}-tab">
                                <!-- single_content  -->
                                <div class="row align-items-center no-gutters">
                                    <div class="col-lg-7">
                                        <div class="dept_info">
                                            <h3>{{ $service->nama_layanan }}</h3>
                                            <p>{{ $service->deskripsi_layanan }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="dept_thumb">
                                            <img src="{{ asset('storage/' . $service->foto_layanan) }}"
                                                alt="{{ $service->nama_layanan }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- single_content  -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- department area_end  -->
    </main>
    <footer>
        <!--? Footer Start-->
        <div class="footer-area section-bg" data-background="{{ 'Landing/assets/img/gallery/footer_bg.jpg'}}">
            <div class="container">
                <div class="footer-top footer-padding">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-8">
                            <div class="single-footer-caption mb-50">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="index"><img src="{{ 'Landing/assets/img/logo/logozoovia_footer.png'}}"
                                            alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>About Us</h4>
                                    <div class="footer-pera">
                                        <p class="info1">Kami menyediakan layanan kesehatan hewan terbaik untuk hewan
                                            peliharaan. </p>
                                        <p class="info1">Hubungi kontak kami dibawah ini .</p>
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
                                    <script>document.write(new Date().getFullYear());</script> All rights reserved |
                                    This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a
                                        href="https://colorlib.com" target="_blank">Colorlib</a>
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

    <script src="{{ 'Landing/assets/js/vendor/modernizr-3.5.0.min.js'}}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ 'Landing/assets/js/vendor/jquery-1.12.4.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/popper.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/bootstrap.min.js'}}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ 'Landing/assets/js/jquery.slicknav.min.js'}}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ 'Landing/assets/js/owl.carousel.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/slick.min.js'}}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="{{ 'Landing/assets/js/wow.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/animated.headline.js'}}"></script>
    <script src="{{ 'Landing/assets/js/jquery.magnific-popup.js'}}"></script>

    <!-- Date Picker -->
    <script src="{{ 'Landing/assets/js/gijgo.min.js'}}"></script>
    <!-- Nice-select, sticky -->
    <script src="{{ 'Landing/assets/js/jquery.nice-select.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/jquery.sticky.js'}}"></script>

    <!-- counter , waypoint -->
    <script src="{{ 'Landing/assets/js/jquery.counterup.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/waypoints.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/jquery.countdown.min.js'}}"></script>
    <!-- contact js -->
    <script src="{{ 'Landing/assets/js/contact.js'}}"></script>
    <script src="{{ 'Landing/assets/js/jquery.form.js'}}"></script>
    <script src="{{ 'Landing/assets/js/jquery.validate.min.js'}}"></script>
    <script src="{{ 'Landing/assets/js/mail-script.js'}}"></script>
    <script src="{{ 'Landing/assets/js/jquery.ajaxchimp.min.js'}}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ 'Landing/assets/js/plugins.js'}}"></script>
    <script src="{{ 'Landing/assets/js/main.js'}}"></script>

</body>

</html>