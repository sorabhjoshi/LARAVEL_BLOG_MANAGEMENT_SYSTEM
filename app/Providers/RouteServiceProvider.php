<?php

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the middleware
        Route::middlewareGroup('web', [
            \App\Http\Middleware\RoleMiddleware::class,  // Register the middleware for route groups
            // Other middleware...
        ]);

        parent::boot();
    }
}
