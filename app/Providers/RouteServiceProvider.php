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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () { // ADMIN
            Route::prefix(config('akawam.admin.path', 'admin'))
                ->name('admin.')
                ->middleware('web')
                ->namespace($this->namespace . "\Admin")
                ->group(base_path('routes/admin.php'));
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->namespace . "\Api")
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace . "\Front")
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
        RateLimiter::for('limiter', fn (Request $request) => Limit::perMinute(50));
    }
}
