<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PrakerinController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Unified Dashboard Entry
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Admin Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/prakerin/{id}/validate', [AdminController::class, 'validatePrakerin'])->name('prakerin.validate');

    // CRUD for Prakerin Students
    Route::get('/prakerin/create', [AdminController::class, 'create'])->name('prakerin.create');
    Route::post('/prakerin', [AdminController::class, 'store'])->name('prakerin.store');
    Route::get('/prakerin/{id}/edit', [AdminController::class, 'edit'])->name('prakerin.edit');
    Route::put('/prakerin/{id}', [AdminController::class, 'update'])->name('prakerin.update');
    Route::delete('/prakerin/{id}', [AdminController::class, 'destroy'])->name('prakerin.destroy');

    // View activities
    Route::get('/prakerin/{id}/activities', [AdminController::class, 'activities'])->name('prakerin.activities');
});

// Prakerin Student Panel Routes
Route::middleware(['auth', 'prakerin'])->prefix('prakerin')->name('prakerin.')->group(function () {
    Route::get('/', [PrakerinController::class, 'dashboard'])->name('dashboard');

    // CRUD for student daily activities
    Route::post('/activities', [PrakerinController::class, 'storeActivity'])->name('activities.store');
    Route::post('/activities/{id}/attachments', [PrakerinController::class, 'addAttachments'])->name('activities.attachments.store');
    Route::put('/activities/{activityId}/attachments/{attachmentId}', [PrakerinController::class, 'replaceAttachment'])->name('activities.attachments.update');
    Route::delete('/activities/{activityId}/attachments/{attachmentId}', [PrakerinController::class, 'deleteAttachmentRecord'])->name('activities.attachments.destroy');
    Route::put('/activities/{id}', [PrakerinController::class, 'updateActivity'])->name('activities.update');
    Route::delete('/activities/{id}', [PrakerinController::class, 'destroyActivity'])->name('activities.destroy');
});
