<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', \App\Http\Controllers\EventController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('tickets', \App\Http\Controllers\TicketController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('bookings', \App\Http\Controllers\BookingController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('attendees', \App\Http\Controllers\AttendeeController::class)->only(['index', 'store', 'update', 'destroy']);
});
