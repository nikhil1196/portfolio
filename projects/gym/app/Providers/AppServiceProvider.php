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
        foreach ([\App\Models\Member::class, \App\Models\Plan::class, \App\Models\Trainer::class, \App\Models\Payment::class, \App\Models\Exercise::class, \App\Models\WorkoutPlan::class, \App\Models\Measurement::class, \App\Models\Attendance::class, \App\Models\PtSession::class, \App\Models\GymClass::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
