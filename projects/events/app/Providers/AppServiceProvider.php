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
        foreach ([\App\Models\Event::class, \App\Models\Category::class, \App\Models\Venue::class, \App\Models\Session::class, \App\Models\Ticket::class, \App\Models\Booking::class, \App\Models\Attendee::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
