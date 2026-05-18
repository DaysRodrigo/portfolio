<?php

use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
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

// Breeze post-login redirect target
Route::get('/dashboard', fn () => redirect()->route('admin.projects.index'))
    ->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'throttle:admin'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('admin.projects.index'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', AdminProjectController::class);
    Route::post('projects/{project}/sync-github', [AdminProjectController::class, 'syncGithub'])
        ->name('projects.sync-github');
});

require __DIR__.'/auth.php';
