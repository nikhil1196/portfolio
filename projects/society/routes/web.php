<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('units', \App\Http\Controllers\UnitController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:units');
    Route::resource('residents', \App\Http\Controllers\ResidentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:residents');
    Route::patch('maintenance/{row}/pay', [\App\Http\Controllers\MaintenanceController::class, 'markPaid'])->name('maintenance.pay');
    Route::resource('maintenance', \App\Http\Controllers\MaintenanceController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:maintenance');
    Route::patch('complaints/{row}/status', [\App\Http\Controllers\ComplaintController::class, 'setStatus'])->name('complaints.status');
    Route::resource('complaints', \App\Http\Controllers\ComplaintController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:complaints');
    Route::resource('notices', \App\Http\Controllers\NoticeController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:notices');
    Route::resource('bookings', \App\Http\Controllers\BookingController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:bookings');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});