<?php

namespace App\Providers;

use App\Models\MatchResult;
use App\Observers\MatchResultObserver;
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
        MatchResult::observe(MatchResultObserver::class);
    }
}
