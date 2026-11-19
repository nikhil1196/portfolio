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
        foreach ([\App\Models\Unit::class, \App\Models\Resident::class, \App\Models\Maintenance::class, \App\Models\Complaint::class, \App\Models\Notice::class, \App\Models\Booking::class, \App\Models\Receipt::class, \App\Models\Visitor::class, \App\Models\Staff::class, \App\Models\Parking::class, \App\Models\FamilyMember::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
