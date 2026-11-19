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
        foreach ([\App\Models\MenuItem::class, \App\Models\Category::class, \App\Models\DiningTable::class, \App\Models\Order::class, \App\Models\Reservation::class, \App\Models\InventoryItem::class, \App\Models\StockMovement::class] as $m) { $m::observe(\App\Observers\AuditObserver::class); }
        //
    }
}
