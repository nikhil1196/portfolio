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

    Route::resource('members', MemberController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:members');
    Route::resource('plans', PlanController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:plans');
    Route::resource('trainers', TrainerController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:trainers');
    Route::patch('payments/{payment}/pay', [PaymentController::class, 'markPaid'])->name('payments.pay');
    Route::resource('payments', PaymentController::class)->only(['index', 'store', 'destroy'])->middleware('perm:payments');

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [AttendanceController::class, 'checkin'])->name('attendance.checkin');
    Route::post('attendance/{attendance}/checkout', [AttendanceController::class, 'checkout'])->name('attendance.checkout');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::resource('exercises', \App\Http\Controllers\ExerciseController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('workout-plans', \App\Http\Controllers\WorkoutPlanController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('workout-items', \App\Http\Controllers\WorkoutItemController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('member-workouts', \App\Http\Controllers\MemberWorkoutController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('measurements', \App\Http\Controllers\MeasurementController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('pt-sessions', \App\Http\Controllers\PtSessionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('gym-classes', \App\Http\Controllers\GymClassController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('class-bookings', \App\Http\Controllers\ClassBookingController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('audit', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
    Route::get('export/{module}', [\App\Http\Controllers\ExportController::class, 'csv'])->name('export.csv');
    Route::get('payments/{payment}/receipt', [\App\Http\Controllers\ReceiptController::class, 'show'])->name('payments.receipt');
    Route::get('v/{module}/{id}', [\App\Http\Controllers\RecordController::class, 'show'])->name('record.show');});