<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Educator\EducatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes - only accessible by admin role
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Educator routes - only accessible by educator and admin roles
Route::middleware(['auth', 'verified', 'role:educator,admin'])->prefix('educator')->name('educator.')->group(function () {
    Route::get('/dashboard', [EducatorController::class, 'dashboard'])->name('dashboard');
    Route::get('/classes', [EducatorController::class, 'classes'])->name('classes');
    Route::get('/students', [EducatorController::class, 'students'])->name('students');
});

require __DIR__.'/auth.php';
