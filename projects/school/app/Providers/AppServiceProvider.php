<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([\App\Models\Student::class, \App\Models\Teacher::class, \App\Models\SchoolClass::class, \App\Models\Fee::class, \App\Models\Result::class, \App\Models\Attendance::class, \App\Models\Notice::class, \App\Models\Subject::class, \App\Models\Staff::class, \App\Models\Timetable::class, \App\Models\Material::class, \App\Models\Assignment::class, \App\Models\Submission::class, \App\Models\Exam::class, \App\Models\FeeStructure::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
