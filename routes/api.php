<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacistController;

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('doctor')->group(function () {
        Route::post('/exam', [DoctorController::class, 'store']);
        Route::put('/prescription/{id}', [DoctorController::class, 'update']);
    });

    Route::prefix('pharmacist')->group(function () {
        Route::get('/prescriptions', [PharmacistController::class, 'index']);
        Route::post('/serve/{id}', [PharmacistController::class, 'serve']);
Route::get('/print/{id}', [PharmacistController::class, 'print']);
});