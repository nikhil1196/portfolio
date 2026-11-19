<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('tickets/{row}/suggest', [\App\Http\Controllers\SupportTicketController::class, 'suggest'])->name('tickets.suggest');
    Route::resource('tickets', \App\Http\Controllers\SupportTicketController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:tickets');
    Route::resource('replies', \App\Http\Controllers\ReplyController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:replies');
    Route::resource('kb', \App\Http\Controllers\KbArticleController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:kb');
    Route::resource('canned', \App\Http\Controllers\CannedReplyController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:canned');
    Route::resource('agents', \App\Http\Controllers\AgentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:agents');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});