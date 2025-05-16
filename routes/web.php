<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Admin\GantiSandiController;

Route::get('/', function () {
    return view('Landing.index');
});

Route::get('/index', function () {
    return view('Landing.index');
});

// Route untuk About
Route::get('/about', function () {
    return view('Landing.about'); // Mengarahkan ke halaman About
});

// Route untuk Dokter
Route::get('/dokter', function () {
    return view('Landing.doctor'); // Mengarahkan ke halaman Dokter
});

Route::get('/pelayanan', function () {
    return view('Landing.pelayanan'); // Mengarahkan ke halaman Dokter
});


Route::middleware(['auth'])->group(function () {
    // Route untuk halaman dan proses ganti password
    Route::get('/ganti-sandi', [GantiSandiController::class, 'showChangePasswordForm'])->name('admin.gantisandi');
    Route::post('/ganti-sandi', [GantiSandiController::class, 'changePassword'])->name('admin.gantisandi');

    // Tambahkan alias untuk 'change.password.form' yang digunakan di controller
    Route::post('/ganti-sandi', [GantiSandiController::class, 'changePassword'])->name('change.password.form');
});




Route::get('/dashboard', [DashboardController::class, 'index']);


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
//BUAT ROUTE MOBILE
// Route::middleware('auth:sanctum')->get('profile_photos/{filename}', [ProfileControllerMobile::class, 'getProfilePhoto']);

Route::name('admin.')->group(function () {
    Route::resource('artikel', ArtikelController::class);
});




// Rute untuk menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Rute untuk meng-handle proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->get('/dashboard', function () {
    return view('admin.dashboard'); // Halaman dashboard
})->name('dashboard');

Route::get('/lupapassword', [LupaPasswordController::class, 'index']);


// Rute untuk Rekam Medis yang ditampilkan di admin
Route::name('admin.')->group(function () {
    Route::get('rekam-medis', [RekamMedisController::class, 'index'])->name('rekammedis.index');
    Route::put('rekam-medis/{rekamMedis}', [RekamMedisController::class, 'update'])->name('rekammedis.update');
    Route::get('rekam-medis/{status?}', [RekamMedisController::class, 'index'])->name('rekammedis.index');

    // Route untuk menghapus rekam medis
    Route::delete('rekam-medis/{rekamMedis}', [RekamMedisController::class, 'destroy'])->name('rekammedis.destroy');
});
