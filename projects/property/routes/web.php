<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('properties', \App\Http\Controllers\PropertyController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:properties');
    Route::resource('tenants', \App\Http\Controllers\TenantController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:tenants');
    Route::resource('leases', \App\Http\Controllers\LeaseController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:leases');
    Route::resource('rents', \App\Http\Controllers\RentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:rents');
    Route::patch('requests/{row}/status', [\App\Http\Controllers\MaintenanceRequestController::class, 'setStatus'])->name('requests.status');
    Route::resource('requests', \App\Http\Controllers\MaintenanceRequestController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:requests');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});