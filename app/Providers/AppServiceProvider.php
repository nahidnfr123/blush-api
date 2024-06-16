<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        Passport::loadKeysFrom(__DIR__ . '/storage/keys');

        ini_set('max_execution_time', '10024');
        ini_set('max_input_time', '10024');
        ini_set('memory_limit', '-1');


        Product::observe(ProductObserver::class);
    }
}
