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
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('venues', \App\Http\Controllers\VenueController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('sessions', \App\Http\Controllers\SessionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('audit', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
    Route::get('export/{module}', [\App\Http\Controllers\ExportController::class, 'csv'])->name('export.csv');
    Route::get('checkin', [\App\Http\Controllers\CheckinController::class, 'index'])->name('checkin');
    Route::post('checkin', [\App\Http\Controllers\CheckinController::class, 'scan'])->name('checkin.scan');
    Route::get('bookings/{booking}/ticket', [\App\Http\Controllers\ETicketController::class, 'show'])->name('bookings.ticket');
    Route::post('bookings/{booking}/paid', [\App\Http\Controllers\ETicketController::class, 'markPaid'])->name('bookings.paid');
    Route::get('v/{module}/{id}', [\App\Http\Controllers\RecordController::class, 'show'])->name('record.show');});