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
        \Illuminate\Pagination\Paginator::defaultView("partials.pagination");
        foreach ([\App\Models\Department::class, \App\Models\Employee::class, \App\Models\HrAttendance::class, \App\Models\Leave::class, \App\Models\Payroll::class, \App\Models\Holiday::class, \App\Models\Announcement::class, \App\Models\Document::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
