<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('contacts', \App\Http\Controllers\ContactController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('leads', \App\Http\Controllers\LeadController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('deals', \App\Http\Controllers\DealController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('tasks', \App\Http\Controllers\TaskController::class)->only(['index', 'store', 'update', 'destroy']);
});
