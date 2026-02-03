<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppointmentAdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ServiceFrontController;
use App\Http\Controllers\AppointmentController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Pages publiques
Route::get('/services', [ServiceFrontController::class, 'index'])->name('services.front');
Route::get('/rendez-vous', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/rendez-vous', [AppointmentController::class, 'store'])->name('appointments.store');

// Dashboard utilisateur
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Routes Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des rendez-vous
    Route::get('/appointments', [AppointmentAdminController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{id}', [AppointmentAdminController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{id}/status', [AppointmentAdminController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::delete('/appointments/{id}', [AppointmentAdminController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments-trashed', [AppointmentAdminController::class, 'trashed'])->name('appointments.trashed');
    Route::post('/appointments/{id}/restore', [AppointmentAdminController::class, 'restore'])->name('appointments.restore');

    // Gestion des patients
    Route::resource('patients', PatientController::class);

    // Gestion des services
    Route::resource('services', ServiceController::class);
});
