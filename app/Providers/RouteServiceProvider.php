<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';
    public const VENDORHOME = '/vendor/home';
    public const VENDORLOGIN = '/vendor/login';
    public const ADMINHOME = '/admin';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $vendorNamespace = 'App\\Http\\Controllers\\Vendor';
    protected $adminNamespace = 'App\\Http\\Controllers\\Admin';
    protected $apiNamespace = 'App\\Http\\Controllers\\Api';
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('vendor')
                ->middleware('web')
                ->name('vendor.')
                ->namespace($this->vendorNamespace)
                ->group(base_path('routes/vendor.php'));

            Route::prefix('admin')
                ->middleware('web')
                ->name('admin.')
                ->namespace($this->adminNamespace)
                ->group(base_path('routes/admin.php'));

            Route::prefix('api')
                ->middleware(['api','cors'])
                ->namespace($this->apiNamespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
