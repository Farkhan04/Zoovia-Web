<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LupaPasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\PengaturanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artikel', function () {
    return view('Admin.artikel');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::get('/lupapassword', [LupaPasswordController::class, 'index']);
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');});
