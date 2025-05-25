<!doctype html>

<html lang="en" class="layout-wide customizer-hide" data-assets-path="{{'/Admin/assets/'}}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Reset Password - Zoovia</title>

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
                <!-- Reset Password -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-heading fw-bold">Zoovia</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-1">Reset Password 🔐</h4>
                        <p class="mb-6">Masukkan password baru untuk akun Anda. Pastikan password yang Anda pilih aman
                            dan mudah diingat.</p>

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

                        <!-- Reset Password Form -->
                        <form id="resetPasswordForm" class="mb-6" action="{{ route('lupa.password.reset.post') }}"
                            method="POST">
                            @csrf

                            <div class="mb-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan password baru" autofocus
                                        required />
                                    <span class="input-group-text cursor-pointer" id="togglePassword">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Password minimal 8 karakter</small>
                            </div>

                            <div class="mb-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Konfirmasi password baru" required />
                                    <span class="input-group-text cursor-pointer" id="togglePasswordConfirmation">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Masukkan ulang password untuk konfirmasi</small>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Kekuatan Password:</span>
                                    <span id="strengthText" class="small text-muted">-</span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100" id="resetBtn">
                                <span id="resetBtnText">Reset Password</span>
                                <span id="resetBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
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
                <!-- /Reset Password -->
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
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        });

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        });

        // Password Strength Checker
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');

            let strength = 0;
            let text = '';
            let color = '';

            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;

            if (strength <= 25) {
                text = 'Lemah';
                color = 'bg-danger';
            } else if (strength <= 50) {
                text = 'Sedang';
                color = 'bg-warning';
            } else if (strength <= 75) {
                text = 'Baik';
                color = 'bg-info';
            } else {
                text = 'Kuat';
                color = 'bg-success';
            }

            strengthBar.style.width = Math.min(strength, 100) + '%';
            strengthBar.className = `progress-bar ${color}`;
            strengthText.textContent = password.length > 0 ? text : '-';
        });

        // Password Match Checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const confirmInput = document.getElementById('password_confirmation');

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    confirmInput.classList.remove('is-invalid');
                    confirmInput.classList.add('is-valid');
                } else {
                    confirmInput.classList.remove('is-valid');
                    confirmInput.classList.add('is-invalid');
                }
            } else {
                confirmInput.classList.remove('is-valid', 'is-invalid');
            }
        }

        document.getElementById('password').addEventListener('input', checkPasswordMatch);
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

        // Loading state untuk reset button
        document.getElementById('resetPasswordForm').addEventListener('submit', function () {
            const resetBtn = document.getElementById('resetBtn');
            const resetBtnText = document.getElementById('resetBtnText');
            const resetBtnSpinner = document.getElementById('resetBtnSpinner');

            resetBtn.disabled = true;
            resetBtnText.classList.add('d-none');
            resetBtnSpinner.classList.remove('d-none');
        });

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