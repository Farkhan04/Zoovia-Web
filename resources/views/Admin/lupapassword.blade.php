<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  data-assets-path="{{'/Admin/assets/'}}"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Lupa Password Admin Zoovia</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="storage/logo.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{'/Admin/assets/vendor/fonts/iconify-icons.css'}}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{'/Admin/assets/vendor/css/core.css'}}" />
    <link rel="stylesheet" href="{{'/Admin/assets/css/demo.css'}}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{'/Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'}}" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{'/Admin/assets/vendor/css/pages/page-auth.css'}}" />

    <!-- Helpers -->
    <script src="{{'/Admin/assets/vendor/js/helpers.js'}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{'/Admin/assets/js/config.js'}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Forgot Password -->
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="{{url('/')}}" class="app-brand-link gap-2">
                  <span class="app-brand-text demo text-heading fw-bold">Zoovia</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Lupa Password? 🔒</h4>
              <p class="mb-6">Masukkan alamat email akun admin puskeswan dan kami akan mengirim kode otp dan instruksi untuk merubah password akun anda</p>
              
              <!-- Alert Messages -->
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

              @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <form id="formAuthentication" class="mb-6" action="{{ route('lupa.password.send') }}" method="POST">
                @csrf
                <div class="mb-6">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Masukkan email anda"
                    value="{{ old('email') }}"
                    autofocus 
                    required />
                  @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100" id="submitBtn">
                  <span id="btnText">Kirim Kode OTP</span>
                  <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
              </form>
              
              <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex justify-content-center">
                  <i class="icon-base bx bx-chevron-left me-1"></i>
                  Kembali ke Login
                </a>
              </div>
            </div>
          </div>
          <!-- /Forgot Password -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->

    <script src="{{'/Admin/assets/vendor/libs/jquery/jquery.js'}}"></script>

    <script src="{{'/Admin/assets/vendor/libs/popper/popper.js'}}"></script>
    <script src="{{'/Admin/assets/vendor/js/bootstrap.js'}}"></script>

    <script src="{{'/Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'}}"></script>

    <script src="{{'/Admin/assets/vendor/js/menu.js'}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{'/Admin/assets/js/main.js'}}"></script>

    <!-- Page JS -->
    <script>
      // Loading state untuk button submit
      document.getElementById('formAuthentication').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
      });

      // Auto hide alerts after 5 seconds
      setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
          const closeBtn = alert.querySelector('.btn-close');
          if (closeBtn) {
            closeBtn.click();
          }
        });
      }, 5000);
    </script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>