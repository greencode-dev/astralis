<?php

namespace App\Providers;

use App\Models\CorpoCeleste;
use App\Observers\CorpoCelesteObserver;
use Illuminate\Support\Facades\Vite;
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
        CorpoCeleste::observe(CorpoCelesteObserver::class);
        Vite::prefetch(concurrency: 3);
    }
}
