<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('units', \App\Http\Controllers\UnitController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('residents', \App\Http\Controllers\ResidentController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('maintenance', \App\Http\Controllers\MaintenanceController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('complaints', \App\Http\Controllers\ComplaintController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('notices', \App\Http\Controllers\NoticeController::class)->only(['index', 'store', 'update', 'destroy']);
});
