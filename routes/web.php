<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentJournalController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherCompanyController;
use App\Http\Controllers\HrdController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= 1. AUTHENTICATION & GUEST ROUTES =================
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ================= 2. AUTHENTICATED & ROLE-BASED ROUTES =================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Umum
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Profil User
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- GROUP KHUSUS SISWA ---
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::post('/profile/request', [StudentController::class, 'requestProfileUpdate'])->name('profile.request');
        Route::get('/journals', [StudentJournalController::class, 'index'])->name('journals.index');
        Route::post('/journals', [StudentJournalController::class, 'store'])->name('journals.store');
        Route::get('/documents', [StudentController::class, 'documents'])->name('documents');
    });

    // --- GROUP KHUSUS GURU PEMBIMBING ---
    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/control-center', [DashboardController::class, 'teacherControlCenter'])->name('control_center');
        Route::post('/approve-profile/{id}', [StudentController::class, 'approveProfile'])->name('approve_profile');
        Route::post('/approve-placement/{id}', [PlacementController::class, 'approvePlacement'])->name('approve_placement');
        
        // Perusahaan & Daftar Perusahaan
        Route::get('/companies', [TeacherCompanyController::class, 'index'])->name('companies.index');
        Route::post('/companies/{company}/request', [TeacherCompanyController::class, 'storeRequest'])->name('companies.store-request');
        
        // Riwayat Pengajuan & Chat Guru
        Route::get('/my-requests', [TeacherCompanyController::class, 'myRequests'])->name('companies.my-requests');
        Route::get('/requests/{companyRequest}/chat', [TeacherCompanyController::class, 'showChat'])->name('companies.chat');
        Route::post('/requests/{companyRequest}/chat', [TeacherCompanyController::class, 'storeChat'])->name('companies.chat.store');
        
        // Fitur Cari & Ajukan Siswa Berdasarkan Sekolah/Nama
        Route::get('/assign-student', [TeacherCompanyController::class, 'createRequest'])->name('assign.create');
        Route::post('/assign-student', [TeacherCompanyController::class, 'storeRequest'])->name('assign.store');
    });

    // --- GROUP KHUSUS HRD PERUSAHAAN ---
    Route::middleware(['role:hrd'])->prefix('hrd')->name('hrd.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'hrdDashboard'])->name('dashboard');
        Route::get('/requests', [HrdController::class, 'requestsIndex'])->name('requests.index');
        Route::patch('/requests/{companyRequest}/status', [HrdController::class, 'updateStatus'])->name('requests.update-status');
        Route::get('/requests/{companyRequest}/chat', [HrdController::class, 'showChat'])->name('requests.chat');
        Route::post('/requests/{companyRequest}/chat', [HrdController::class, 'storeChat'])->name('requests.chat.store');
    });

    // --- GROUP KHUSUS ADMIN ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
    });

    // Manajemen Data Master (Perusahaan & Penempatan)
    Route::resource('companies', CompanyController::class);
    Route::resource('placements', PlacementController::class);
});