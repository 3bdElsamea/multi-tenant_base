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
    public const HOME = '/';
    /**
     * The controller namespaces for the application.
     */
    protected $namespace = 'App\\Http\\Controllers';
    protected $dashboard_namespace = 'App\Http\Controllers\Api\Dashboard';
    protected $super_admin_namespace = 'App\Http\Controllers\Api\Dashboard\SuperAdmin';
    protected $admin_namespace = 'App\Http\Controllers\Api\Dashboard\Admin';


    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapMacros();
            $this->mapWebRoutes();
            $this->mapApiRoutes();
        });
    }


    /**
     * Rate limiters throttle incoming requests to your application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Map the Web Routes
     */
    protected function mapWebRoutes(): void
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Get the Central Domains
     */

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains', []);
    }

    /**
     * Map the Api Routes
     */
    protected function mapApiRoutes(): void
    {
        foreach ($this->centralDomains() as $domain) {

            Route::prefix('api')
                ->middleware('api')
                ->domain($domain)
                ->group(function () use ($domain) {
                    Route::prefix('super')
                        ->namespace($this->super_admin_namespace)
                        ->group(base_path('routes/api/superadmin.php'));
                    Route::prefix('admin')
                        ->namespace($this->admin_namespace)
                        ->group(base_path('routes/api/admin.php'));
                });
        }
    }

    /**
     *Map Macros
     */
    protected function mapMacros(): void
    {
        Route::macro('apiWithSoftDelete', function ($uri, $controller) {

//            $param = Str::singular($uri);
//            Route::get($uri, $controller . '@index');
//            Route::post($uri, $controller . '@store');
//            Route::get($uri . '/{' . $param . '}', $controller . '@show');
//            Route::put($uri . '/{' . $param . '}', $controller . '@update');
//            Route::patch($uri . '/{' . $param . '}', $controller . '@update');
//            Route::delete($uri . '/{' . $param . '}', $controller . '@destroy');
            Route::get($uri . '/trashed', $controller . '@trashed');
            Route::get($uri . '/{id}/trashed', $controller . '@showTrashed');
            Route::post($uri . '/{id}/restore', $controller . '@restore');
            Route::post($uri . '/restore-all', $controller . '@restoreAll');
            Route::delete($uri . '/{id}/force-delete', $controller . '@forceDelete');
            Route::apiResource($uri, $controller);
        });
    }


}
