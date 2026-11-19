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
        foreach ([\App\Models\SupportTicket::class, \App\Models\Reply::class, \App\Models\KbArticle::class, \App\Models\CannedReply::class, \App\Models\Agent::class, \App\Models\Customer::class, \App\Models\Rating::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
