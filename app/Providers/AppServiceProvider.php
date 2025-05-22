<?php

namespace App\Providers;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;  
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
        // Set default locale to Vietnamese
        Paginator::useBootstrapFive();
        Builder::defaultStringLength(191);

    }
   
}
