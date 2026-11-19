<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:departments');
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:employees');
    Route::resource('attendance', \App\Http\Controllers\HrAttendanceController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:attendance');
    Route::patch('leaves/{row}/status', [\App\Http\Controllers\LeaveController::class, 'setStatus'])->name('leaves.status');
    Route::resource('leaves', \App\Http\Controllers\LeaveController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:leaves');
    Route::resource('payroll', \App\Http\Controllers\PayrollController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:payroll');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});