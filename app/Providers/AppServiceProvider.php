<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;//change
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();//change

        // Set UTF-8 encoding for all database connections
        Schema::defaultStringLength(191);

        // Set proper PHP encoding
        ini_set('default_charset', 'utf-8');
        header('Content-Type: text/html; charset=utf-8');
    }
}
