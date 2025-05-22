<?php

use App\Http\Controllers\Mobile\Antrian\AntrianController;
use App\Http\Controllers\Mobile\ArtikelController;
use App\Http\Controllers\Mobile\Dokter\DokterController;
use App\Http\Controllers\Mobile\GantiPassword\GantiPasswordController;
use App\Http\Controllers\Mobile\Hewanku\HewankuController;
use App\Http\Controllers\Mobile\Layanan\LayananController;
use App\Http\Controllers\Mobile\Login\LoginController;
use App\Http\Controllers\Mobile\Logout\LogoutController;
use App\Http\Controllers\Mobile\Profile\ProfileControllerMobile;
use App\Http\Controllers\Mobile\Register\RegisterController;
use App\Http\Controllers\Mobile\RekamMedis\RekamMedisController;
use App\Http\Controllers\Mobile\User\UserController;
use App\Http\Controllers\Mobile\VerifikasiOTP\VerifikasiOtpController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider (atau melalui bootstrap
| yang sudah dikonfigurasi) within a group which is assigned the "api"
| middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/auth/google', [LoginController::class, 'loginWithGoogle']);
    Route::post('/otp/verify', [VerifikasiOtpController::class, 'verify'])->name('verification.verify');
    Route::post('/otp/resend', [VerifikasiOtpController::class, 'resend'])->name('verification.resend');
    Route::controller(GantiPasswordController::class)->group(function () {
        Route::post('/ganti/password', 'gantiPassword');
        Route::post('/password/forgot','forgotPassword');
        Route::post('/password/verify-otp','verifyResetOtp');
        Route::post('/password/reset', 'resetPassword');
    });

    Route::middleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class])->group(function () {

        Route::post('/logout', [LogoutController::class, 'logout']);

        Route::controller(UserController::class)->group(function () {
            Route::get('/user/{id}', 'getUser');
            Route::get('/users', 'getAllUser');
        });

        Route::controller(ProfileControllerMobile::class)->group(function () {
            Route::post('/user/profile/createOrUpdate', 'createOrUpdate');
        });

        Route::controller(HewankuController::class)->group(function () {
            Route::post('/hewan/create', 'store');
            Route::get('/hewan/user/{id}', 'getByUserId');
            Route::post('/hewan/{id}', 'update');
            Route::delete('/hewan/{id}', 'destroy');
        });

        Route::controller(DokterController::class)->group(function () {
            Route::get('/dokters', 'index');
            Route::get('/dokter/layanan/{layananId}', [DokterController::class, 'getByLayananId']);
            Route::post('/dokter/create', 'store');
            Route::post('/dokter/{id}', 'update');
            Route::delete('/dokter/{id}', [DokterController::class, 'destroy']);
        });

        Route::controller(LayananController::class)->group(function () {
            Route::get('/layanans', 'index');
            Route::post('/layanan/create', 'store');
            Route::get('/layanan/{id}', 'show');
            Route::post('/layanan/{id}', 'update');
            Route::delete('/layanan/{id}', 'destroy');
        });

        Route::controller(AntrianController::class)->group(function () {
            Route::get('/antrian', 'index');
            Route::get('/antrian/summary', 'getQueueSummary');
            Route::post('/antrian/create', 'store');
            Route::get('/antrian/{id}', 'show');
            Route::post('/antrian/{id}', 'update');
            Route::post('/antrian/{id}/status', 'updateStatus');
            Route::delete('/antrian/{id}', 'destroy');
            Route::get('/antrian/user/{userId}', 'getByUserId');
            Route::get('/antrian/layanan/{layananId}', 'getByLayananId');
            Route::get('/antrian/status/{status}', 'getByStatus');
        });

        // Route untuk Rekam Medis
        Route::controller(RekamMedisController::class)->group(function () {
            Route::get('/rekam-medis', 'index');
            Route::post('/rekam-medis', 'store');
            Route::get('/rekam-medis/{id}', 'show');
            Route::get('/rekam-medis/hewan/{hewanId}', 'getByHewanId');
            Route::put('/rekam-medis/{id}', 'update');
            Route::delete('/rekam-medis/{id}', 'destroy');
        });

        Route::controller(ArtikelController::class)->group(function () {
            Route::get('/artikels', 'index');
            Route::get('/artikel/{id}', 'show');
            Route::post('/artikel/create', 'store');
            Route::post('/artikel/{id}', 'update');
            Route::delete('/artikel/{id}', 'destroy');
        });
    });
});
