<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';
    protected $adminNamespace = 'App\\Http\\Controllers\\AdminApi';
    protected $userNamespace = 'App\\Http\\Controllers\\UserApi';
    protected $corporateNamespace = 'App\\Http\\Controllers\\CorporateApi';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        parent::boot();

        $this->routes(function () {
            Route::/*prefix('api')
                ->*/middleware('api')
                ->namespace($this->userNamespace)
                ->domain(config('passport.domainUser'))
                ->group(base_path('routes/api/user.php'));

            Route::/*prefix('api')
                ->*/middleware('api')
                ->namespace($this->adminNamespace)
                ->domain(config('passport.domainAdmin'))
                ->group(base_path('routes/api/admin.php'));

            Route::/*prefix('api')
                ->*/middleware('api')
                ->namespace($this->corporateNamespace)
                ->domain(config('passport.domainCorporate'))
                ->group(base_path('routes/api/corporate.php'));

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
