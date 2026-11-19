<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', \App\Http\Controllers\StudentController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:students');
    Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:teachers');
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:classes');
    Route::patch('fees/{row}/pay', [\App\Http\Controllers\FeeController::class, 'markPaid'])->name('fees.pay');
    Route::resource('fees', \App\Http\Controllers\FeeController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:fees');
    Route::resource('results', \App\Http\Controllers\ResultController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:results');
    Route::resource('attendance', \App\Http\Controllers\AttendanceController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:attendance');
    Route::resource('notices', \App\Http\Controllers\NoticeController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('perm:notices');

    Route::resource('roles', \App\Http\Controllers\RoleController::class)->only(['index','store','update','destroy']);
    Route::resource('team', \App\Http\Controllers\TeamController::class)->only(['index','store','update','destroy']);
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('staff', \App\Http\Controllers\StaffController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('timetable', \App\Http\Controllers\TimetableController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('materials', \App\Http\Controllers\MaterialController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('assignments', \App\Http\Controllers\AssignmentController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('staff', \App\Http\Controllers\StaffController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('timetable', \App\Http\Controllers\TimetableController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('materials', \App\Http\Controllers\MaterialController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('assignments', \App\Http\Controllers\AssignmentController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('submissions', \App\Http\Controllers\SubmissionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('exams', \App\Http\Controllers\ExamController::class)->only(['index', 'store', 'update', 'destroy']);
});