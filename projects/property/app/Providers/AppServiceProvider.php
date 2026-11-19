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
        foreach ([\App\Models\Property::class, \App\Models\Tenant::class, \App\Models\Lease::class, \App\Models\Rent::class, \App\Models\MaintenanceRequest::class, \App\Models\Expense::class, \App\Models\Document::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
