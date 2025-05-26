<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $artikel->judul }} - Zoovia Puskeswan-Web</title>
    <meta name="description" content="{{ Str::limit(strip_tags($artikel->deskripsi), 160) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('Landing/assets/css/style.css') }}">

</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-area">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="{{ route('landing.index') }}">
                                    <img src="{{ asset('Landing/assets/img/logo/logozoovia.png') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{ route('landing.index') }}">Home</a></li>
                                            <li><a href="{{ route('landing.about') }}">About</a></li>
                                            <li><a href="{{ route('landing.doctors') }}">Doctors</a></li>
                                            <li><a href="{{ route('landing.services') }}">Pelayanan</a></li>
                                            <li><a href="{{ route('articles.index') }}">Artikel</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                    <a href="{{ route('login') }}" class="btn header-btn">Login</a>
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
    </header>

    <main>
        <!-- Article Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-400 py-24">
            <div class="container mx-auto px-4">
                <div class="flex flex-col space-y-8">
                    <div class="w-full">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="flex space-x-4 text-white">
                                <li><a href="{{ route('landing.index') }}" class="hover:underline">Home</a></li>
                                <li><a href="{{ route('articles.index') }}" class="hover:underline">Artikel</a></li>
                                <li class="text-white font-semibold" aria-current="page">
                                    {{ Str::limit($artikel->judul, 50) }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Article Title -->
                    <h1 class="text-4xl font-bold text-white">{{ $artikel->judul }}</h1>

                    <!-- Article Meta -->
                    <div class="flex space-x-8 text-white mt-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <span>Oleh: {{ $artikel->penulis }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $artikel->tanggal->format('d F Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-clock"></i>
                            <span>
                                {{ str_word_count(strip_tags($artikel->deskripsi)) > 200 ? ceil(str_word_count(strip_tags($artikel->deskripsi)) / 200) : 1 }}
                                min read
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div class="article-content py-32">
            <div class="container mx-auto px-8">
                <div class="flex justify-center">
                    <div class="w-full lg:w-9/12">
                        <!-- Back to Articles Link -->
                        <a href="{{ route('landing.index') }}"
                            class="flex items-center text-blue-600 hover:underline mb-12 text-2xl font-semibold">
                            <i class="fas fa-arrow-left mr-3"></i> Kembali ke Artikel
                        </a>

                        <!-- Article Thumbnail -->
                        @if($artikel->thumbnail)
                            <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}"
                                class="w-full rounded-xl shadow-lg mb-12">
                        @endif

                        <!-- Article Body -->
                        <div class="article-body text-2xl text-gray-800 leading-relaxed space-y-8 mb-12">
                            {!! nl2br(e($artikel->deskripsi)) !!}
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons mt-12 py-8 border-t border-b border-gray-200">
                            <h5 class="text-3xl font-bold text-gray-800 mb-6"><i class="fas fa-share-alt mr-3"></i>
                                Bagikan Artikel Ini:</h5>
                            <div class="flex space-x-8">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank"
                                    class="share-btn bg-blue-700 hover:bg-blue-800 text-white px-10 py-4 rounded-full text-lg">
                                    <i class="fab fa-facebook-f mr-3"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($artikel->judul) }}"
                                    target="_blank"
                                    class="share-btn bg-blue-500 hover:bg-blue-600 text-white px-10 py-4 rounded-full text-lg">
                                    <i class="fab fa-twitter mr-3"></i> Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . request()->fullUrl()) }}"
                                    target="_blank"
                                    class="share-btn bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-full text-lg">
                                    <i class="fab fa-whatsapp mr-3"></i> WhatsApp
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($artikel->judul) }}"
                                    target="_blank"
                                    class="share-btn bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-full text-lg">
                                    <i class="fab fa-telegram-plane mr-3"></i> Telegram
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        @if($related_articles->count() > 0)
            <div class="related-articles py-32 bg-gray-50">
                <div class="container mx-auto px-8">
                    <div class="w-full">
                        <h3 class="text-4xl font-bold text-center mb-12">Artikel Terkait</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
                        @foreach($related_articles as $related)
                            <div class="related-card bg-white rounded-xl shadow-lg overflow-hidden">
                                @if($related->thumbnail)
                                    <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->judul }}"
                                        class="w-full h-72 object-cover">
                                @else
                                    <img src="{{ asset('Landing/assets/img/gallery/blog1.png') }}" alt="{{ $related->judul }}"
                                        class="w-full h-72 object-cover">
                                @endif
                                <div class="p-8">
                                    <h5 class="text-2xl font-semibold text-gray-800">
                                        <a href="{{ route('article.detail', $related->id) }}" class="hover:text-blue-600">
                                            {{ Str::limit($related->judul, 80) }}
                                        </a>
                                    </h5>
                                    <p class="text-lg text-gray-600">{{ Str::limit(strip_tags($related->deskripsi), 100) }}</p>
                                    <div class="text-sm text-gray-500 mt-4">
                                        <i class="fas fa-calendar-alt"></i> {{ $related->tanggal->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-area section-bg" data-background="{{ asset('Landing/assets/img/gallery/footer_bg.jpg') }}">
            <div class="container">
                <div class="footer-top footer-padding">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-8">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-logo">
                                    <a href="{{ route('landing.index') }}">
                                        <img src="{{ asset('Landing/assets/img/logo/logozoovia_footer.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>About Us</h4>
                                    <div class="footer-pera">
                                        <p class="info1">Kami menyediakan layanan kesehatan hewan terbaik untuk hewan
                                            peliharaan.</p>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-9 col-lg-8">
                            <div class="footer-copy-right">
                                <p>
                                    Copyright &copy;
                                    <script>document.write(new Date().getFullYear());</script>
                                    All rights reserved | This template is made with <i class="fa fa-heart"
                                        aria-hidden="true"></i> by <a href="https://colorlib.com"
                                        target="_blank">Colorlib</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4">
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
    </footer>

    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>
</body>

</html>