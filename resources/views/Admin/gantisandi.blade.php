<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Ganti Password | Pusat Kesehatan Hewan</title>
    <meta name="description" content="Form ganti password untuk admin Pusat Kesehatan Hewan" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="Admin/assets/img/favicon/favicon.ico" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        // Konfigurasi Tailwind
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
        
        // Fungsi toggle password visibility
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
</head>

<body class="bg-gray-50 font-inter">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-paw text-2xl text-blue-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Ganti Password</h1>
                <p class="text-gray-600">Pusat Kesehatan Hewan</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form id="password-form" action="{{ route('admin.gantisandi') }}" method="POST">
                    @csrf

                    <!-- Alert Success -->
                    @if (session('status'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md mb-4">
                            <div class="flex">
                                <i class="fas fa-check-circle mt-0.5 mr-3"></i>
                                <span>{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Alert Error -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md mb-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-circle mt-0.5 mr-3 flex-shrink-0"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Password Lama -->
                    <div class="mb-4">
                        <label for="current-password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Lama
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-10" 
                                   id="current-password"
                                   name="current_password" 
                                   placeholder="Masukkan password lama" 
                                   required />
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" 
                                    id="current-password-toggle" 
                                    onclick="togglePasswordVisibility('current-password')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <label for="new-password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-10" 
                                   id="new-password" 
                                   name="new_password"
                                   placeholder="Masukkan password baru" 
                                   required />
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" 
                                    id="new-password-toggle"
                                    onclick="togglePasswordVisibility('new-password')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        
                        <!-- Password Strength Meter -->
                        <div class="mt-2">
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gray-300 rounded-full transition-all duration-300" 
                                     id="password-meter" 
                                     style="width: 0%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500">Kekuatan password:</span>
                                <span class="text-xs font-medium" id="password-feedback">Lemah</span>
                            </div>
                        </div>
                        
                        <!-- Password Tips -->
                        <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md hidden" id="password-tips">
                            <p class="text-sm text-blue-800 font-medium mb-2">Tips password yang kuat:</p>
                            <ul class="text-xs text-blue-700 space-y-1">
                                <li>• Minimal 8 karakter</li>
                                <li>• Gunakan huruf besar dan kecil</li>
                                <li>• Tambahkan angka</li>
                                <li>• Tambahkan simbol (!@#$%^&*)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-6">
                        <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-10" 
                                   id="confirm-password"
                                   name="new_password_confirmation" 
                                   placeholder="Konfirmasi password baru" 
                                   required />
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" 
                                    id="confirm-password-toggle"
                                    onclick="togglePasswordVisibility('confirm-password')">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-key mr-2"></i>
                        Perbarui Password
                    </button>

                    <!-- Tombol Kembali -->
                    <button type="button" 
                            onclick="window.history.back()" 
                            class="w-full mt-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    © 2025 Pusat Kesehatan Hewan
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newPassword = document.getElementById('new-password');
            const passwordMeter = document.getElementById('password-meter');
            const passwordFeedback = document.getElementById('password-feedback');
            const passwordTips = document.getElementById('password-tips');
            const confirmPassword = document.getElementById('confirm-password');
            const passwordForm = document.getElementById('password-form');

            // Show/hide password tips
            newPassword.addEventListener('focus', function() {
                passwordTips.classList.remove('hidden');
            });

            newPassword.addEventListener('blur', function() {
                if (newPassword.value.length === 0) {
                    passwordTips.classList.add('hidden');
                }
            });

            // Password strength meter
            newPassword.addEventListener('input', function() {
                const value = newPassword.value;
                let strength = 0;
                let feedback = '';
                let color = '';

                if (value.length >= 8) strength += 1;
                if (value.match(/[A-Z]/)) strength += 1;
                if (value.match(/[0-9]/)) strength += 1;
                if (value.match(/[^A-Za-z0-9]/)) strength += 1;

                switch (strength) {
                    case 0:
                        passwordMeter.style.width = '0%';
                        passwordMeter.className = 'h-full bg-gray-300 rounded-full transition-all duration-300';
                        feedback = 'Lemah';
                        passwordFeedback.className = 'text-xs font-medium text-gray-500';
                        break;
                    case 1:
                        passwordMeter.style.width = '25%';
                        passwordMeter.className = 'h-full bg-red-500 rounded-full transition-all duration-300';
                        feedback = 'Lemah';
                        passwordFeedback.className = 'text-xs font-medium text-red-600';
                        break;
                    case 2:
                        passwordMeter.style.width = '50%';
                        passwordMeter.className = 'h-full bg-yellow-500 rounded-full transition-all duration-300';
                        feedback = 'Sedang';
                        passwordFeedback.className = 'text-xs font-medium text-yellow-600';
                        break;
                    case 3:
                        passwordMeter.style.width = '75%';
                        passwordMeter.className = 'h-full bg-blue-500 rounded-full transition-all duration-300';
                        feedback = 'Bagus';
                        passwordFeedback.className = 'text-xs font-medium text-blue-600';
                        break;
                    case 4:
                        passwordMeter.style.width = '100%';
                        passwordMeter.className = 'h-full bg-green-500 rounded-full transition-all duration-300';
                        feedback = 'Kuat';
                        passwordFeedback.className = 'text-xs font-medium text-green-600';
                        break;
                }

                passwordFeedback.textContent = feedback;
            });

            // Form validation
            passwordForm.addEventListener('submit', function(e) {
                if (newPassword.value !== confirmPassword.value) {
                    e.preventDefault();
                    confirmPassword.classList.add('border-red-500');
                    confirmPassword.classList.remove('border-gray-300');
                    
                    // Show error message
                    let errorMsg = confirmPassword.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'text-red-600 text-sm mt-1 error-message';
                        confirmPassword.parentNode.insertBefore(errorMsg, confirmPassword.nextSibling);
                    }
                    errorMsg.textContent = 'Password baru dan konfirmasi password tidak cocok!';
                    
                    confirmPassword.focus();
                    return false;
                }
                
                // Remove error styling if passwords match
                confirmPassword.classList.remove('border-red-500');
                confirmPassword.classList.add('border-gray-300');
                const errorMsg = confirmPassword.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            });

            // Remove error on input
            confirmPassword.addEventListener('input', function() {
                if (confirmPassword.value === newPassword.value) {
                    confirmPassword.classList.remove('border-red-500');
                    confirmPassword.classList.add('border-gray-300');
                    const errorMsg = confirmPassword.parentNode.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
        });
    </script>
</body>

</html>