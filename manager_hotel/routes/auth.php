<?php

use App\Http\Controllers\Backend\Auth\AuthenticatedSessionBackendController;
use App\Http\Controllers\Backend\Auth\ConfirmablePasswordBackendController;
use App\Http\Controllers\Backend\Auth\EmailVerificationNotificationBackendController;
use App\Http\Controllers\Backend\Auth\EmailVerificationPromptBackendController;
use App\Http\Controllers\Backend\Auth\NewPasswordBackendController;
use App\Http\Controllers\Backend\Auth\PasswordBackendController;
use App\Http\Controllers\Backend\Auth\PasswordResetLinkBackendController;
use App\Http\Controllers\Backend\Auth\RegisteredUserBackendController;
use App\Http\Controllers\Backend\Auth\VerifyEmailBackendController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserBackendController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserBackendController::class, 'store']);

    Route::get('login', [AuthenticatedSessionBackendController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionBackendController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkBackendController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkBackendController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordBackendController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordBackendController::class, 'store'])
                ->name('password.store');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptBackendController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailBackendController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationBackendController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordBackendController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordBackendController::class, 'store']);

    Route::put('password', [PasswordBackendController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionBackendController::class, 'destroy'])
                ->name('logout');
});
