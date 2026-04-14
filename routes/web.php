<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\AuthController;
use App\Services\MedicineService;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth')->group(function () {

    Route::middleware('role:dokter')->prefix('doctor')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'index']); 
        Route::get('/form', [DoctorController::class, 'form']); 
        Route::get('/detail/{id}', [DoctorController::class, 'detail']); 
        Route::post('/exam', [DoctorController::class, 'store']);
        Route::get('/edit/{id}', [DoctorController::class, 'edit']);
        Route::put('/update/{id}', [DoctorController::class, 'update']);
        Route::get('download-berkas/{id}', [DoctorController::class, 'downloadBerkas']);
    });

    Route::middleware('role:apoteker')->prefix('pharmacist')->group(function () {
        Route::get('/dashboard', [PharmacistController::class, 'index']);
        Route::get('/detail/{id}', [PharmacistController::class, 'detail']);
        Route::post('/serve/{id}', [PharmacistController::class, 'serve']);
        Route::get('/print/{id}', [PharmacistController::class, 'print']);
        Route::get('download-berkas/{id}', [PharmacistController::class, 'downloadBerkas']);

    });

    Route::get('/medicines', [MedicineController::class, 'index']);
    Route::get('/medicines/{id}/prices', [MedicineController::class, 'prices']);
    
    Route::get('/test-login', function () {
        $service = new MedicineService();
        return $service->login(); 
    });
});