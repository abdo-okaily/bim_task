<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Spatie\Translatable\Facades\Translatable;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->wantsJson() && request()->segment(1)!='vendor' && request()->segment(1)!='admin')
        {
            app()->setLocale(request()->header("lang"));
        }
        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);
    }
}
