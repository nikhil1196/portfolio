<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('patients', \App\Http\Controllers\PatientController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('doctors', \App\Http\Controllers\DoctorController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('prescriptions', \App\Http\Controllers\PrescriptionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('bills', \App\Http\Controllers\BillController::class)->only(['index', 'store', 'update', 'destroy']);
});
