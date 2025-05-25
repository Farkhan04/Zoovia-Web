<?php

use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\LayananController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AntrianController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GantiSandiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LupaPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page Routes
Route::get('/', function () {
    return view('Landing.index');
});
Route::get('/index', function () {
    return view('Landing.index');
});
Route::get('/about', function () {
    return view('Landing.about');
});
Route::get('/dokter', function () {
    return view('Landing.doctor');
});
Route::get('/pelayanan', function () {
    return view('Landing.pelayanan');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Lupa Password Routes
Route::prefix('lupapassword')->name('lupa.password')->group(function () {
    Route::get('/', [LupaPasswordController::class, 'index']);
    Route::post('/send-otp', [LupaPasswordController::class, 'sendOtp'])->name('.send');
    
    Route::get('/verify', [LupaPasswordController::class, 'showVerifyForm'])->name('.verify');
    Route::post('/verify-otp', [LupaPasswordController::class, 'verifyOtp'])->name('.verify.post');
    Route::post('/resend-otp', [LupaPasswordController::class, 'resendOtp'])->name('.resend');
    
    Route::get('/reset', [LupaPasswordController::class, 'showResetForm'])->name('.reset');
    Route::post('/reset-password', [LupaPasswordController::class, 'resetPassword'])->name('.reset.post');
});

// Protected Admin Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ganti Password
    Route::get('/ganti-sandi', [GantiSandiController::class, 'showChangePasswordForm'])->name('admin.gantisandi');
    Route::post('/ganti-sandi', [GantiSandiController::class, 'changePassword'])->name('change.password.form');

    // Admin routes with admin prefix and name
    Route::prefix('admin')->name('admin.')->group(function () {
        // Profile Management
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Artikel Management
        Route::resource('artikel', ArtikelController::class);

        // Dokter Management
        Route::resource('dokter', DokterController::class);

        // Layanan Management
        Route::resource('layanan', LayananController::class);

        // Rekam Medis Management
        Route::get('rekammedis', [RekamMedisController::class, 'index'])->name('rekammedis.index');
        Route::get('rekammedis/hewan/{id}', [RekamMedisController::class, 'show'])->name('rekammedis.show');
        Route::post('rekammedis', [RekamMedisController::class, 'store'])->name('rekammedis.store');
        Route::put('rekammedis/{rekamMedis}', [RekamMedisController::class, 'update'])->name('rekammedis.update');
        Route::delete('rekammedis/{rekamMedis}', [RekamMedisController::class, 'destroy'])->name('rekammedis.destroy');

        // Antrian Management
        Route::prefix('antrian')->name('antrian.')->group(function () {
            // Daftar dan detail antrian
            Route::get('/', [AntrianController::class, 'index'])->name('index');
            Route::get('/{id}', [AntrianController::class, 'show'])->name('show')->where('id', '[0-9]+');

            // Scan barcode dan pencarian
            Route::get('/scan/barcode', [AntrianController::class, 'scanBarcode'])->name('scan');
            Route::post('/search', [AntrianController::class, 'searchAntrian'])->name('search');

            // Check-in dan proses antrian
            Route::post('/check-in', [AntrianController::class, 'checkIn'])->name('checkin');
            Route::get('/{id}/confirm', [AntrianController::class, 'confirmCheckIn'])->name('confirm');
            Route::post('/{id}/process', [AntrianController::class, 'processQueue'])->name('process');

            // Selesaikan antrian dan tambah rekam medis
            Route::post('/{id}/complete', [AntrianController::class, 'completeQueue'])->name('complete');

            // Panggil antrian berikutnya
            Route::get('/next/call', [AntrianController::class, 'callNextQueue'])->name('callnext');
        });
    });
});