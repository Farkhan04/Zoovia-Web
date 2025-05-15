<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lupa Password - Zoovia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #b799ff, #8e63e7, #663399);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
      overflow: hidden;
      color: white;
    }

    [data-bs-theme="dark"] body {
      background: linear-gradient(135deg, #1a1a2e, #282850, #370097);
    }

    .forgot-box {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 2.5rem;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.8s ease;
      position: relative;
    }

    .logo-img {
      width: 80px;
      margin: 0 auto 15px;
      display: block;
    }

    .img-anjing {
      max-width: 200px;
      margin: 20px auto;
      display: block;
    }

    .title {
      text-align: center;
      font-size: 22px;
      font-weight: 600;
      color: #fff;
    }

    .subtitle {
      text-align: center;
      font-size: 14px;
      color: #e0e0e0;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 12px;
      padding: 10px 14px;
    }

    .btn-send {
      background: linear-gradient(45deg, #663399, #b799ff);
      color: white;
      font-weight: 600;
      border-radius: 12px;
      box-shadow: 0 0 8px rgba(102, 51, 153, 0.5);
      width: 100%;
      padding: 10px;
      margin-top: 10px;
    }

    .btn-send:hover {
      background: linear-gradient(45deg, #370097, #a88fe7);
    }

    .back a {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
    }

    .toggle-mode {
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 99;
    }

    #loader {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 999;
    }

    .alert-toast {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #4ade80;
      color: white;
      padding: 12px 18px;
      border-radius: 8px;
      font-size: 14px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
      display: none;
    }

    .alert-toast.show {
      display: block;
      animation: fadeInOut 4s ease forwards;
    }

    @keyframes fadeInOut {
      0% { opacity: 0; transform: translateY(-20px); }
      10%, 90% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(-20px); }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>

  <!-- Toggle -->
  <div class="toggle-mode">
    <button class="btn btn-sm btn-light" onclick="toggleTheme()">🌗</button>
  </div>

  <!-- Loader -->
  <div id="loader">
    <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status"></div>
  </div>

  <div class="forgot-box text-white">
    <img src="{{ asset('Admin/assets/img/LupaPassword/logo.png') }}" alt="Logo Zoovia" class="logo-img">
    <img src="{{ asset('Admin/assets/img/LupaPassword/anjing.png') }}" alt="Anjing" class="img-anjing">
    <h2 class="title">Lupa Password</h2>
    <p class="subtitle">Masukkan email kamu untuk mendapatkan link reset password.</p>

    @if (session('status'))
      <div class="alert-toast show" id="toast">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('lupa.password.kirim') }}" onsubmit="return handleSubmit(this)">
      @csrf
      <input type="email" name="email" class="form-control mb-3" placeholder="Email kamu..." required>

      @error('email')
        <div style="color: #ffd6d6; font-size: 13px; margin-bottom: 10px;">
          {{ $message }}
        </div>
      @enderror

      <button type="submit" class="btn btn-send" id="submitBtn">Kirim Link</button>
    </form>

    <div class="text-center mt-3 back">
      <a href="{{ route('login') }}">← Kembali ke Login</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleTheme() {
      const html = document.documentElement;
      const current = html.getAttribute("data-bs-theme");
      const newTheme = current === "dark" ? "light" : "dark";
      html.setAttribute("data-bs-theme", newTheme);
      localStorage.setItem("theme", newTheme);
    }

    function handleSubmit(form) {
      document.getElementById("submitBtn").disabled = true;
      document.getElementById("loader").style.display = "block";
      return true;
    }

    window.onload = () => {
      const toast = document.getElementById('toast');
      if (toast) {
        setTimeout(() => toast.classList.remove('show'), 4000);
      }

      const savedTheme = localStorage.getItem("theme");
      if (savedTheme) {
        document.documentElement.setAttribute("data-bs-theme", savedTheme);
      }
    };
  </script>
</body>
</html>
