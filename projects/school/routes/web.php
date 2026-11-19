<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', \App\Http\Controllers\StudentController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('fees', \App\Http\Controllers\FeeController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('results', \App\Http\Controllers\ResultController::class)->only(['index', 'store', 'update', 'destroy']);
});
