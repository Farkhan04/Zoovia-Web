<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Mobile\Profile\ProfileControllerMobile;
use App\Http\Controllers\Admin\ArtikelController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/index', function () {
    return view('Landing.index');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'index']);

//BUAT ROUTE MOBILE
Route::middleware('auth:sanctum')->get('profile_photos/{filename}', [ProfileControllerMobile::class, 'getProfilePhoto']);
Route::resource('/artikel', ArtikelController::class);


// Rute untuk menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Rute untuk meng-handle proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard'); // Halaman dashboard
})->name('dashboard');
