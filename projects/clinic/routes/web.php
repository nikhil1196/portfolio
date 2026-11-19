<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('patients', \App\Http\Controllers\PatientController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:patients');
    Route::resource('doctors', \App\Http\Controllers\DoctorController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:doctors');
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:appointments');
    Route::resource('prescriptions', \App\Http\Controllers\PrescriptionController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:prescriptions');
    Route::resource('bills', \App\Http\Controllers\BillController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:bills');
    Route::resource('clinics', \App\Http\Controllers\ClinicController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:clinics');
    Route::resource('schedules', \App\Http\Controllers\ScheduleController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:schedules');
    Route::resource('payments', \App\Http\Controllers\PaymentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:payments');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});