<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ObiPlus\ObiPlus\ObiPlusServiceProvider;

class APIMiddleware
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        app()->register(ObiPlusServiceProvider::class);
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'tr';     // set laravel localization
        app()->setLocale($local);
        return $next($request);
    }
}

