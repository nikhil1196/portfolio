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
        foreach ([\App\Models\Contact::class, \App\Models\Lead::class, \App\Models\Deal::class, \App\Models\Task::class, \App\Models\Activity::class, \App\Models\Product::class, \App\Models\Quote::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
