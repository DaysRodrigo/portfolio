<?php

use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SkillTagController as AdminSkillTagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('throttle:public')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// Breeze post-login redirect target
Route::get('/dashboard', fn () => redirect()->route('admin.projects.index'))
    ->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes — 2FA required after login
Route::prefix('admin')->name('admin.')->middleware(['auth', 'throttle.otp', '2fa', 'throttle:admin'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('admin.projects.index'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', AdminProjectController::class);
    Route::post('projects/{project}/sync-github', [AdminProjectController::class, 'syncGithub'])
        ->name('projects.sync-github');
    Route::delete('projects/{project}/images/{image}', [AdminProjectController::class, 'destroyImage'])
        ->name('projects.images.destroy');

    Route::resource('skill-tags', AdminSkillTagController::class);
});

require __DIR__.'/auth.php';
