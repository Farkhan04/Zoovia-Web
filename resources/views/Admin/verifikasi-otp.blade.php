<!doctype html>

<html lang="en" class="layout-wide customizer-hide" data-assets-path="{{'/Admin/assets/'}}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Verifikasi OTP - Zoovia</title>

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
    <link rel="stylesheet" href="{{'/Admin/assets/vendor/css/core.css'}}" />
    <link rel="stylesheet" href="{{'/Admin/assets/css/demo.css'}}" />
    <link rel="stylesheet" href="{{'/Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'}}" />
    <link rel="stylesheet" href="{{'/Admin/assets/vendor/css/pages/page-auth.css'}}" />

    <!-- Helpers -->
    <script src="{{'/Admin/assets/vendor/js/helpers.js'}}"></script>
    <script src="{{'/Admin/assets/js/config.js'}}"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Verify OTP -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-heading fw-bold">Zoovia</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-1">Verifikasi Kode OTP 📱</h4>
                        <p class="mb-6">
                            Masukkan kode OTP 6 digit yang telah dikirim ke email<br>
                            <strong>{{ $email }}</strong>
                        </p>

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

                        <!-- OTP Timer -->
                        <div class="mb-4 text-center">
                            <p class="mb-0">Kode akan expired dalam: <span id="timer"
                                    class="fw-bold text-primary">10:00</span></p>
                        </div>

                        <!-- Verify OTP Form -->
                        <form id="verifyOtpForm" class="mb-6" action="{{ route('lupa.password.verify.post') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="mb-6">
                                <label for="otp" class="form-label">Kode OTP</label>
                                <input type="text" class="form-control text-center @error('otp') is-invalid @enderror"
                                    id="otp" name="otp" placeholder="000000" maxlength="6" value="{{ old('otp') }}"
                                    style="font-size: 1.5rem; letter-spacing: 0.5rem;" autofocus required />
                                @error('otp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Masukkan 6 digit kode OTP yang dikirim ke email Anda</small>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100 mb-3" id="verifyBtn">
                                <span id="verifyBtnText">Verifikasi OTP</span>
                                <span id="verifyBtnSpinner" class="spinner-border spinner-border-sm d-none"
                                    role="status" aria-hidden="true"></span>
                            </button>
                        </form>

                        <!-- Resend OTP Form -->
                        <form id="resendOtpForm" action="{{ route('lupa.password.resend') }}" method="POST"
                            class="mb-4">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="text-center">
                                <p class="mb-2">Tidak menerima kode OTP?</p>
                                <button type="submit" class="btn btn-link p-0" id="resendBtn" disabled>
                                    <span id="resendBtnText">Kirim Ulang OTP</span>
                                    <span id="resendBtnSpinner" class="spinner-border spinner-border-sm d-none"
                                        role="status" aria-hidden="true"></span>
                                </button>
                                <small class="d-block text-muted mt-1" id="resendInfo">Anda dapat mengirim ulang setelah
                                    <span id="resendTimer">60</span> detik</small>
                            </div>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('lupa.password') }}" class="d-flex justify-content-center">
                                <i class="icon-base bx bx-chevron-left me-1"></i>
                                Kembali ke Lupa Password
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Verify OTP -->
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{'/Admin/assets/vendor/libs/jquery/jquery.js'}}"></script>
    <script src="{{'/Admin/assets/vendor/libs/popper/popper.js'}}"></script>
    <script src="{{'/Admin/assets/vendor/js/bootstrap.js'}}"></script>
    <script src="{{'/Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'}}"></script>
    <script src="{{'/Admin/assets/vendor/js/menu.js'}}"></script>
    <script src="{{'/Admin/assets/js/main.js'}}"></script>

    <!-- Page JS -->
    <script>
        // OTP Input Validation - Only Numbers
        document.getElementById('otp').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Loading state untuk verify button
        document.getElementById('verifyOtpForm').addEventListener('submit', function () {
            const verifyBtn = document.getElementById('verifyBtn');
            const verifyBtnText = document.getElementById('verifyBtnText');
            const verifyBtnSpinner = document.getElementById('verifyBtnSpinner');

            verifyBtn.disabled = true;
            verifyBtnText.classList.add('d-none');
            verifyBtnSpinner.classList.remove('d-none');
        });

        // Loading state untuk resend button
        document.getElementById('resendOtpForm').addEventListener('submit', function () {
            const resendBtn = document.getElementById('resendBtn');
            const resendBtnText = document.getElementById('resendBtnText');
            const resendBtnSpinner = document.getElementById('resendBtnSpinner');

            resendBtn.disabled = true;
            resendBtnText.classList.add('d-none');
            resendBtnSpinner.classList.remove('d-none');
        });

        // Timer untuk OTP expiry (10 menit)
        let otpTime = 10 * 60; // 10 minutes in seconds
        const timerElement = document.getElementById('timer');

        const otpTimer = setInterval(function () {
            const minutes = Math.floor(otpTime / 60);
            const seconds = otpTime % 60;

            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (otpTime <= 0) {
                clearInterval(otpTimer);
                timerElement.textContent = '00:00';
                timerElement.classList.add('text-danger');

                // Disable verify form when expired
                document.getElementById('verifyBtn').disabled = true;
                document.getElementById('otp').disabled = true;

                // Show expired message
                const expiredAlert = document.createElement('div');
                expiredAlert.className = 'alert alert-warning';
                expiredAlert.innerHTML = 'Kode OTP telah expired. Silahkan kirim ulang kode OTP.';
                document.querySelector('.card-body').insertBefore(expiredAlert, document.getElementById('verifyOtpForm'));
            }

            otpTime--;
        }, 1000);

        // Timer untuk resend button (60 detik)
        let resendTime = 60;
        const resendBtn = document.getElementById('resendBtn');
        const resendTimerElement = document.getElementById('resendTimer');
        const resendInfo = document.getElementById('resendInfo');

        const resendTimer = setInterval(function () {
            resendTimerElement.textContent = resendTime;

            if (resendTime <= 0) {
                clearInterval(resendTimer);
                resendBtn.disabled = false;
                resendInfo.style.display = 'none';
            }

            resendTime--;
        }, 1000);

        // Auto hide alerts after 5 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.click();
                }
            });
        }, 5000);
    </script>
</body>

</html>