<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Auth\LupaPasswordController;


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


Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'index']);
Route::resource('/artikel', ArtikelController::class);


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


// Routes untuk RekamMedis
    Route::resource('/rekammedis', RekamMedisController::class);
