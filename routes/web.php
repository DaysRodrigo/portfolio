<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProjectController;
use App\Http\Controllers\Public\SkillsController;
use App\Http\Controllers\Public\TimelineController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('throttle:public')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/skills', [SkillsController::class, 'index'])->name('skills.index');
    Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'throttle:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
