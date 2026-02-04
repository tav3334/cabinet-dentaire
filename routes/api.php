<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TreatmentController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\MedicalFileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public services (for frontend display)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {

    // Authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Patients
    Route::apiResource('patients', PatientController::class);

    // Appointments
    Route::apiResource('appointments', AppointmentController::class);
    Route::post('/appointments/{id}/restore', [AppointmentController::class, 'restore']);

    // Services (protected CRUD operations)
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    // Treatments
    Route::apiResource('treatments', TreatmentController::class);

    // Consultations
    Route::apiResource('consultations', ConsultationController::class);

    // Medical Files
    Route::apiResource('medical-files', MedicalFileController::class);
    Route::get('/medical-files/{medicalFile}/download', [MedicalFileController::class, 'download']);
});
