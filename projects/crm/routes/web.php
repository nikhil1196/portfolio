<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('contacts', \App\Http\Controllers\ContactController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:contacts');
    Route::resource('leads', \App\Http\Controllers\LeadController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:leads');
    Route::get('pipeline', [\App\Http\Controllers\PipelineController::class, 'index'])->name('pipeline');
    Route::patch('deals/{row}/stage', [\App\Http\Controllers\PipelineController::class, 'move'])->name('deals.stage');
    Route::resource('deals', \App\Http\Controllers\DealController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:deals');
    Route::resource('tasks', \App\Http\Controllers\TaskController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:tasks');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::resource('activities', \App\Http\Controllers\ActivityController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('products', \App\Http\Controllers\ProductController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotes', \App\Http\Controllers\QuoteController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('audit', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.index');
    Route::get('export/{module}', [\App\Http\Controllers\ExportController::class, 'csv'])->name('export.csv');
    Route::get('quotes/{quote}/print', [\App\Http\Controllers\QuotePrintController::class, 'show'])->name('quotes.print');
    Route::post('activities/{activity}/done', \App\Http\Controllers\ActivityDoneController::class)->name('activities.done');
    Route::get('v/{module}/{id}', [\App\Http\Controllers\RecordController::class, 'show'])->name('record.show');});