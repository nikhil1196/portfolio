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
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('documents', \App\Http\Controllers\DocumentController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('audit', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
    Route::get('export/{module}', [\App\Http\Controllers\ExportController::class, 'csv'])->name('export.csv');
    Route::get('reports/expenses', [\App\Http\Controllers\ExpenseReportController::class, 'index'])->name('reports.expenses');
    Route::get('rents/{rent}/receipt', [\App\Http\Controllers\RentReceiptController::class, 'show'])->name('rents.receipt');
    Route::post('rents/{rent}/paid', [\App\Http\Controllers\RentReceiptController::class, 'markPaid'])->name('rents.paid');
    Route::post('leases/{lease}/renew', \App\Http\Controllers\LeaseRenewController::class)->name('leases.renew');
    Route::get('v/{module}/{id}', [\App\Http\Controllers\RecordController::class, 'show'])->name('record.show');});