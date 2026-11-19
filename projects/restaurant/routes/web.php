<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('menu', \App\Http\Controllers\MenuItemController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:menu');
    Route::resource('tables', \App\Http\Controllers\DiningTableController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:tables');
    Route::resource('orders', \App\Http\Controllers\OrderController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:orders');
    Route::get('pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos');
    Route::post('pos', [\App\Http\Controllers\PosController::class, 'store'])->name('pos.store');
    Route::post('pos/{order}/settle', [\App\Http\Controllers\PosController::class, 'settle'])->name('pos.settle');
    Route::get('kitchen', [\App\Http\Controllers\KitchenController::class, 'index'])->name('kitchen');
    Route::post('kitchen/{order}/advance', [\App\Http\Controllers\KitchenController::class, 'advance'])->name('kitchen.advance');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
});