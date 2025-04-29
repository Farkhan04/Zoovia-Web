<?php

use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Logout\LogoutController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\VerifikasiOTP\VerifikasiOtpController;
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
    Route::post('/logout', [LogoutController::class, 'logout'])
        ->middleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class]);

});
