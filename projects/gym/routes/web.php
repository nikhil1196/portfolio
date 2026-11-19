<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('members', MemberController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('plans', PlanController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('trainers', TrainerController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('payments', PaymentController::class)->only(['index', 'store', 'destroy']);

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [AttendanceController::class, 'checkin'])->name('attendance.checkin');
    Route::post('attendance/{attendance}/checkout', [AttendanceController::class, 'checkout'])->name('attendance.checkout');
});
