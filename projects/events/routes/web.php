<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', \App\Http\Controllers\EventController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:events');
    Route::resource('tickets', \App\Http\Controllers\TicketController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:tickets');
    Route::resource('bookings', \App\Http\Controllers\BookingController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:bookings');
    Route::patch('attendees/{row}/checkin', [\App\Http\Controllers\AttendeeController::class, 'checkin'])->name('attendees.checkin');
    Route::resource('attendees', \App\Http\Controllers\AttendeeController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:attendees');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});