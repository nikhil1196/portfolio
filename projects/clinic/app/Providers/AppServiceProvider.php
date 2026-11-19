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
        foreach ([\App\Models\Patient::class, \App\Models\Doctor::class, \App\Models\Appointment::class, \App\Models\Prescription::class, \App\Models\Bill::class, \App\Models\Clinic::class, \App\Models\Schedule::class, \App\Models\Payment::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
