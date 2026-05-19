<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'throttle.otp', '2fa'])->group(function () {
    // Dedicated POST route for the OTP challenge.
    // The 2fa middleware intercepts this request, validates one_time_password,
    // sets the session key, then passes through to the redirect below.
    Route::post('two-factor/challenge', fn () => redirect()->intended(route('admin.projects.index')))
        ->name('two-factor.challenge');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // ── Two-Factor Authentication ─────────────────────────────────────────────
    // These routes are excluded from the 2FA middleware so the user can
    // complete the challenge (or set up 2FA) without an infinite redirect loop.
    // Logout is also excluded — no one should be locked out of logging out.
    Route::withoutMiddleware(\PragmaRX\Google2FALaravel\Middleware::class)->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
        Route::get('two-factor/manage', [TwoFactorController::class, 'manage'])->name('two-factor.manage');
        Route::get('two-factor/setup', [TwoFactorController::class, 'setup'])->name('two-factor.setup');
        Route::post('two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
        Route::post('two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
    });
});
