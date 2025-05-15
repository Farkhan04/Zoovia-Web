<!doctype html>
<html lang="id" class="layout-menu-fixed layout-compact" data-assets-path="Admin/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Ganti Password | Pusat Kesehatan Hewan</title>
    <meta name="description" content="Form ganti password untuk admin Pusat Kesehatan Hewan" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="Admin/assets/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="Admin/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="Admin/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="Admin/assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="Admin/assets/vendor/js/helpers.js"></script>
    <script src="Admin/assets/js/config.js"></script>
    
    <!-- PENTING: Tambahkan fungsi di head -->
    <script>
        // Definisikan fungsi toggle password sebagai fungsi global
        function togglePasswordVisibility(inputId) {
            var input = document.getElementById(inputId);
            var button = document.getElementById(inputId + '-toggle');
            var icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye-slash';
            }
        }
    </script>
    
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #7E57C2 0%, #673AB7 100%);
            position: relative;
            overflow: hidden;
        }

        .content-wrapper::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            box-shadow:
                0 0 50px 30px rgba(255, 255, 255, 0.1),
                100px 100px 0 rgba(255, 255, 255, 0.1),
                200px 50px 0 rgba(255, 255, 255, 0.1),
                300px 300px 0 rgba(255, 255, 255, 0.1),
                400px 100px 0 rgba(255, 255, 255, 0.1);
        }

        .form-container {
            width: 100%;
            max-width: 480px;
            padding: 20px;
            position: relative;
            z-index: 2;
            transform: translateY(0);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .card {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-radius: 1.5rem;
            overflow: hidden;
            background-color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }

        .card::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: url('/api/placeholder/150/150') bottom right/contain no-repeat;
            opacity: 0.05;
            z-index: 0;
            pointer-events: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background: linear-gradient(45deg, #9C27B0, #673AB7);
            padding: 2rem 1.5rem;
            border-bottom: none;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-header h5 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .pet-icon {
            font-size: 3rem;
            color: white;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .pet-icon i {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: bounce 2s infinite alternate;
        }

        .pet-icon i:nth-child(2) {
            animation-delay: 0.3s;
        }

        .pet-icon i:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-10px);
            }
        }

        .card-body {
            padding: 2rem;
            position: relative;
            z-index: 1;
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: #5E35B1;
            font-size: 0.875rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 2px solid #EDE7F6;
            background-color: #FAFAFA;
            transition: all 0.3s;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #9575CD;
            box-shadow: 0 0 0 0.25rem rgba(103, 58, 183, 0.25);
            background-color: #fff;
        }

        .input-group-text {
            cursor: pointer;
            background-color: #FAFAFA;
            border: 2px solid #EDE7F6;
            border-left: none;
            color: #9575CD;
            transition: all 0.3s;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        .input-group-text:hover {
            color: #5E35B1;
        }

        .btn-primary {
            background: linear-gradient(45deg, #9C27B0, #673AB7);
            border: none;
            width: 100%;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(103, 58, 183, 0.4);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            transform: translateX(-100%);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #8E24AA, #5E35B1);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(103, 58, 183, 0.5);
        }

        .btn-primary:hover::after {
            transform: translateX(100%);
        }

        .btn-back {
            width: 100%;
            background-color: transparent;
            color: #9575CD;
            border: 2px solid #EDE7F6;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #F3E5F5;
            color: #5E35B1;
            border-color: #D1C4E9;
        }

        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-group-merge .form-control:not(:last-child) {
            border-right: none;
            padding-right: 0;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .paw-bullet {
            position: relative;
            padding-left: 25px;
            color: #7E57C2;
        }

        .paw-bullet::before {
            content: '\f1b0';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #9575CD;
        }

        .password-strength {
            height: 6px;
            margin-top: 8px;
            border-radius: 10px;
            background: #EDE7F6;
            overflow: hidden;
            position: relative;
        }

        .password-strength-meter {
            height: 100%;
            border-radius: 10px;
            width: 0%;
            transition: all 0.5s;
        }

        .password-feedback {
            font-size: 0.75rem;
            margin-top: 5px;
            text-align: right;
            color: #7E57C2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .password-tips {
            font-size: 0.75rem;
            color: #7E57C2;
            margin-top: 5px;
            padding: 5px 10px;
            background-color: #F3E5F5;
            border-radius: 6px;
            display: none;
        }

        .password-tips.show {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .watermark {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            z-index: 10;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Paw print animation */
        .paw-prints {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 2;
            opacity: 0.7;
        }

        .paw {
            width: 20px;
            height: 20px;
            background-color: rgba(156, 39, 176, 0.1);
            border-radius: 50%;
            position: absolute;
            animation: walk 5s linear infinite;
        }

        .paw::before,
        .paw::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 10px;
            background-color: rgba(156, 39, 176, 0.1);
            border-radius: 50%;
        }

        .paw::before {
            top: -5px;
            left: 4px;
        }

        .paw::after {
            top: -5px;
            right: 4px;
        }

        .paw:nth-child(1) {
            left: 0;
            animation-delay: 0s;
        }

        .paw:nth-child(2) {
            left: 30px;
            animation-delay: 0.5s;
        }

        .paw:nth-child(3) {
            left: 60px;
            animation-delay: 1s;
        }

        .paw:nth-child(4) {
            left: 90px;
            animation-delay: 1.5s;
        }

        .paw:nth-child(5) {
            left: 120px;
            animation-delay: 2s;
        }

        @keyframes walk {
            0% {
                transform: translateY(0) scale(0);
                opacity: 0;
            }

            20% {
                transform: translateY(-20px) scale(1);
                opacity: 1;
            }

            80% {
                transform: translateY(-80px) scale(1);
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) scale(0);
                opacity: 0;
            }
        }

        /* Purple particles background */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float-particle 20s linear infinite;
        }

        .particle:nth-child(1) {
            top: 10%;
            left: 20%;
            animation-duration: 25s;
        }

        .particle:nth-child(2) {
            top: 30%;
            left: 70%;
            width: 8px;
            height: 8px;
            animation-duration: 30s;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            top: 60%;
            left: 30%;
            width: 5px;
            height: 5px;
            animation-duration: 18s;
            animation-delay: 1s;
        }

        .particle:nth-child(4) {
            top: 80%;
            left: 80%;
            width: 7px;
            height: 7px;
            animation-duration: 22s;
            animation-delay: 4s;
        }

        .particle:nth-child(5) {
            top: 40%;
            left: 40%;
            width: 4px;
            height: 4px;
            animation-duration: 15s;
            animation-delay: 3s;
        }

        .particle:nth-child(6) {
            top: 90%;
            left: 10%;
            width: 6px;
            height: 6px;
            animation-duration: 20s;
            animation-delay: 5s;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-150px) translateX(100px);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        <div class="paw-prints">
            <div class="paw"></div>
            <div class="paw"></div>
            <div class="paw"></div>
            <div class="paw"></div>
            <div class="paw"></div>
        </div>
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <div class="pet-icon">
                        <i class="fas fa-paw"></i>
                        <i class="fas fa-cat"></i>
                        <i class="fas fa-dog"></i>
                    </div>
                    <h5>Ganti Password</h5>
                </div>
                <div class="card-body">
                    <!-- Form dengan fungsi toggle password yang diperbaiki -->
                    <form id="password-form" action="{{ route('admin.gantisandi') }}" method="POST">
                        @csrf

                        <!-- Alert untuk Status -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible mb-3" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Alert untuk Error -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible mb-3" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Password Lama -->
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Password Lama</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" id="current-password"
                                    name="current_password" placeholder="Masukkan password lama Anda" required />
                                <!-- PERUBAHAN: Gunakan atribut onclick -->
                                <span class="input-group-text cursor-pointer" id="current-password-toggle" 
                                      onclick="togglePasswordVisibility('current-password')">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label for="new-password" class="form-label">Password Baru</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" id="new-password" name="new_password"
                                    placeholder="Masukkan password baru" required />
                                <!-- PERUBAHAN: Gunakan atribut onclick -->
                                <span class="input-group-text cursor-pointer" id="new-password-toggle"
                                      onclick="togglePasswordVisibility('new-password')">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                            @error('new_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Strength Meter -->
                        <div class="password-strength">
                            <div class="password-strength-meter" id="password-meter"></div>
                        </div>
                        <div class="password-feedback mb-3">
                            <span class="paw-bullet">Gunakan kombinasi huruf, angka, dan simbol</span>
                            <span id="password-feedback">Lemah</span>
                        </div>
                        <div class="password-tips mb-3" id="password-tips">
                            <ul class="mb-0 ps-3">
                                <li>Minimal 8 karakter</li>
                                <li>Gunakan huruf besar dan kecil</li>
                                <li>Tambahkan angka</li>
                                <li>Tambahkan simbol (!@#$%^&*)</li>
                            </ul>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" id="confirm-password"
                                    name="new_password_confirmation" placeholder="Konfirmasi password baru Anda" required />
                                <!-- PERUBAHAN: Gunakan atribut onclick -->
                                <span class="input-group-text cursor-pointer" id="confirm-password-toggle"
                                      onclick="togglePasswordVisibility('confirm-password')">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Kirim -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Perbarui Password
                            </button>
                        </div>

                        <!-- Tombol Kembali -->
                        <div class="mt-3">
                            <button type="button" class="btn-back" onclick="window.history.back()">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Watermark -->
    <div class="watermark">© 2025, Pusat Kesehatan Hewan - Dibuat dengan <i class="fas fa-heart"
            style="color: #E91E63;"></i> untuk hewan kesayangan Anda</div>

    <!-- Core JS -->
    <script src="Admin/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="Admin/assets/vendor/libs/popper/popper.js"></script>
    <script src="Admin/assets/vendor/js/bootstrap.js"></script>
    <script src="Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="Admin/assets/vendor/js/menu.js"></script>
    <script src="Admin/assets/js/main.js"></script>

    <script>
        // Script untuk password strength meter dan validasi form
        document.addEventListener('DOMContentLoaded', function() {
            // Password strength meter
            const newPassword = document.getElementById('new-password');
            const passwordMeter = document.getElementById('password-meter');
            const passwordFeedback = document.getElementById('password-feedback');
            const passwordTips = document.getElementById('password-tips');

            newPassword.addEventListener('focus', function() {
                passwordTips.classList.add('show');
            });

            newPassword.addEventListener('blur', function() {
                if (newPassword.value.length === 0) {
                    passwordTips.classList.remove('show');
                }
            });

            newPassword.addEventListener('input', function() {
                const value = newPassword.value;
                let strength = 0;
                let feedback = '';

                if (value.length >= 8) strength += 1;
                if (value.match(/[A-Z]/)) strength += 1;
                if (value.match(/[0-9]/)) strength += 1;
                if (value.match(/[^A-Za-z0-9]/)) strength += 1;

                switch (strength) {
                    case 0:
                        passwordMeter.style.width = '0%';
                        passwordMeter.style.backgroundColor = '#e8eaec';
                        feedback = 'Lemah';
                        break;
                    case 1:
                        passwordMeter.style.width = '25%';
                        passwordMeter.style.backgroundColor = '#F44336';
                        feedback = 'Lemah';
                        break;
                    case 2:
                        passwordMeter.style.width = '50%';
                        passwordMeter.style.backgroundColor = '#FF9800';
                        feedback = 'Sedang';
                        break;
                    case 3:
                        passwordMeter.style.width = '75%';
                        passwordMeter.style.backgroundColor = '#7E57C2';
                        feedback = 'Bagus';
                        break;
                    case 4:
                        passwordMeter.style.width = '100%';
                        passwordMeter.style.backgroundColor = '#673AB7';
                        feedback = 'Kuat';
                        break;
                }

                passwordFeedback.textContent = feedback;
            });

            // Konfirmasi password match
            const confirmPassword = document.getElementById('confirm-password');
            const passwordForm = document.getElementById('password-form');

            passwordForm.addEventListener('submit', function(e) {
                if (newPassword.value !== confirmPassword.value) {
                    e.preventDefault(); // Cegah form dikirim
                    confirmPassword.style.borderColor = '#F44336';
                    alert('Password baru dan konfirmasi password tidak cocok!');
                    return;
                }
                // Form akan dikirim secara normal jika password cocok
            });

            // Animasi tambahan - membuat tampilan lebih hidup
            function animatePaw() {
                const paws = document.querySelectorAll('.paw');
                paws.forEach(paw => {
                    const randomRotate = Math.floor(Math.random() * 30) - 15;
                    paw.style.transform = `rotate(${randomRotate}deg)`;
                });
                setTimeout(animatePaw, 3000);
            }

            // Jalankan animasi saat halaman dimuat
            animatePaw();
        });
    </script>
</body>

</html>