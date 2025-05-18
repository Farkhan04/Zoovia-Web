{{-- resources/views/admin/password-success.blade.php --}}
<!doctype html>
<html lang="id" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('Admin/assets/') }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Password Berhasil Diubah | Pusat Kesehatan Hewan</title>
    <meta name="description" content="Halaman sukses ganti password di Pusat Kesehatan Hewan" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Admin/assets/img/favicon/favicon.ico') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/demo.css') }}" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
        }
        
        .success-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #7E57C2 0%, #673AB7 100%);
            position: relative;
            overflow: hidden;
        }
        
        .success-wrapper::before {
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
        
        .success-container {
            width: 100%;
            max-width: 500px;
            margin: 0 20px;
            position: relative;
            z-index: 2;
            transform: translateY(0);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .success-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            position: relative;
        }
        
        .success-header {
            background: linear-gradient(135deg, #7CB342, #558B2F);
            color: white;
            padding: 2.5rem 2rem 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .success-header::before {
            content: '';
            position: absolute;
            top: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .success-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .success-checkmark {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
            animation: bounceIn 0.8s;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0); opacity: 0; }
            60% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .success-checkmark i {
            font-size: 40px;
            color: #558B2F;
        }
        
        .success-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .success-body {
            padding: 2.5rem 2rem;
            position: relative;
            z-index: 1;
        }
        
        .success-message {
            font-size: 1.1rem;
            color: #4A4A4A;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .success-info {
            background: #F0F4F9;
            padding: 1rem;
            border-radius: 1rem;
            color: #5E35B1;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            display: inline-block;
        }
        
        .success-timer {
            font-size: 0.9rem;
            color: #9575CD;
            margin-bottom: 2rem;
        }
        
        .success-timer span {
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .success-btn {
            background: linear-gradient(45deg, #9C27B0, #673AB7);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(103, 58, 183, 0.4);
            display: inline-block;
            text-decoration: none;
        }
        
        .success-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(103, 58, 183, 0.5);
            color: white;
        }
        
        .walking-paws {
            position: absolute;
            bottom: 30px;
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 1;
        }
        
        .paw-print {
            display: inline-block;
            margin: 0 5px;
            color: #D1C4E9;
            font-size: 20px;
            animation: walkAnimation 2s infinite;
            opacity: 0;
        }
        
        .paw-print:nth-child(1) { animation-delay: 0s; }
        .paw-print:nth-child(2) { animation-delay: 0.2s; }
        .paw-print:nth-child(3) { animation-delay: 0.4s; }
        .paw-print:nth-child(4) { animation-delay: 0.6s; }
        .paw-print:nth-child(5) { animation-delay: 0.8s; }
        
        @keyframes walkAnimation {
            0% { transform: translateX(-20px) scale(0.8); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(20px) scale(0.8); opacity: 0; }
        }
        
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
    </style>
</head>

<body>
    <div class="success-wrapper">
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="success-container">
            <div class="success-card">
                <div class="success-header">
                    <div class="success-checkmark">
                        <i class="fas fa-check"></i>
                    </div>
                    <h1>Password Berhasil Diubah!</h1>
                </div>
                <div class="success-body">
                    <p class="success-message">
                        Password Anda telah berhasil diperbarui. Silakan gunakan password baru Anda 
                        untuk login selanjutnya.
                    </p>
                    
                    <div class="success-info">
                        <i class="fas fa-shield-alt"></i> Untuk keamanan, pastikan menyimpan password Anda dengan aman.
                    </div>
                    
                    <div class="success-timer">
                        Dialihkan ke Dashboard dalam <span id="countdown">3</span> detik
                    </div>
                    
                    <a href="{{ route('dashboard') }}" class="success-btn">
                        <i class="fas fa-home me-2"></i> Ke Dashboard
                    </a>
                </div>
                
                <div class="walking-paws">
                    <i class="fas fa-paw paw-print"></i>
                    <i class="fas fa-paw paw-print"></i>
                    <i class="fas fa-paw paw-print"></i>
                    <i class="fas fa-paw paw-print"></i>
                    <i class="fas fa-paw paw-print"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Watermark -->
    <div class="watermark">© 2025, Zoovia - Dibuat dengan <i class="fas fa-heart"
            style="color: #E91E63;"></i> untuk hewan kesayangan Anda</div>
    
    <!-- Core JS -->
    <script src="{{ asset('Admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Admin/assets/vendor/js/bootstrap.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Countdown timer
            const countdownEl = document.getElementById('countdown');
            let timeLeft = 3;
            
            const countdownTimer = setInterval(function() {
                timeLeft--;
                countdownEl.textContent = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    // Menggunakan route dashboard yang benar
                    window.location.href = "{{ route('dashboard') }}";
                }
            }, 1000);
        });
    </script>
</body>
</html>