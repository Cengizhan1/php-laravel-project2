<?php

namespace App\Providers;

use App\Http\Middleware\Policy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use ObiPlus\ObiPlus\ObiPlus;
use ObiPlus\ObiPlus\ObiPlusApplicationServiceProvider;

class ObiPlusServiceProvider extends ObiPlusApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::aliasMiddleware('obiplus.policy', Policy::class);
    }

    /**
     * Register the Obi Plus routes.
     *
     * @return void
     */
    protected function routes()
    {
        ObiPlus::routes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
