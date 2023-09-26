<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmailVerificationNotificationController;
use App\Http\Controllers\API\NewPasswordController;
use App\Http\Controllers\API\PasswordController;
use App\Http\Controllers\API\PasswordResetLinkController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VerifyEmailController;

Route::post('/register', [AuthController::class, 'register'])
                ->name('register');

Route::post('/login', [AuthController::class, 'login'])
                ->name('login');

Route::controller(AuthController::class)->group(function () {
    //Route::post('login', 'login');
    //Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');

Route::put('/update-password', [PasswordController::class, 'update'])
                ->middleware('auth:api')
                ->name('password.update');
                
Route::patch('/update-profile', [ProfileController::class, 'update'])
                ->middleware('auth:api')
                ->name('profile.update');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth:api', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth:api', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/userdelete', [ProfileController::class, 'destroy'])
                ->middleware('auth:api')
                ->name('user.delete');

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->post('/user', function (Request $request) {
    return $request->user();
});
