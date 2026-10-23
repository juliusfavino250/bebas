<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\CompanyController;

// 1. Halaman Utama langsung ke Login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// 2. Halaman Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// 3. Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. Area yang Membutuhkan Login (Terproteksi)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Group Route Khusus Siswa
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::post('/profile/request', [StudentController::class, 'requestProfileUpdate'])->name('profile.request');
        Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
        Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');
        Route::get('/documents', [StudentController::class, 'documents'])->name('documents');
    });

    // Group Route Khusus Guru Pembimbing
    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/control-center', [DashboardController::class, 'teacherControlCenter'])->name('control_center');
        Route::post('/approve-profile/{id}', [StudentController::class, 'approveProfile'])->name('approve_profile');
        Route::post('/approve-placement/{id}', [PlacementController::class, 'approvePlacement'])->name('approve_placement');
    });

    // Group Route Khusus HRD Perusahaan
    Route::middleware(['role:hrd'])->prefix('hrd')->name('hrd.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'hrdDashboard'])->name('dashboard');
    });

    // Manajemen Data Master (Perusahaan & Penempatan)
    Route::resource('companies', CompanyController::class);
    Route::resource('placements', PlacementController::class);
});