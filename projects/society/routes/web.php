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
    Route::resource('receipts', \App\Http\Controllers\ReceiptController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('visitors', \App\Http\Controllers\VisitorController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('staff', \App\Http\Controllers\StaffController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('parking', \App\Http\Controllers\ParkingController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('members', \App\Http\Controllers\FamilyMemberController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('audit', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
    Route::get('export/{module}', [\App\Http\Controllers\ExportController::class, 'csv'])->name('export.csv');
    Route::get('receipts/{receipt}/print', [\App\Http\Controllers\ReceiptPrintController::class, 'show'])->name('receipts.print');
    Route::post('complaints/{complaint}/start', [\App\Http\Controllers\ComplaintActionController::class, 'start'])->name('complaints.start');
    Route::post('complaints/{complaint}/resolve', [\App\Http\Controllers\ComplaintActionController::class, 'resolve'])->name('complaints.resolve');
    Route::post('visitors/{visitor}/approve', [\App\Http\Controllers\VisitorActionController::class, 'approve'])->name('visitors.approve');
    Route::post('visitors/{visitor}/checkout', [\App\Http\Controllers\VisitorActionController::class, 'checkout'])->name('visitors.checkout');
    Route::get('v/{module}/{id}', [\App\Http\Controllers\RecordController::class, 'show'])->name('record.show');});