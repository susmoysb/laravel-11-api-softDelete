<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteBindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Array mapping route parameters to model classes
        $bindings = [
            'user'    => \App\Models\User::class,
            // Add more model bindings as needed...
        ];

        // Register each binding
        foreach ($bindings as $parameter => $modelClass) {
            Route::bind($parameter, function ($value) use ($modelClass) {
                return $modelClass::withTrashed()
                    ->where((new $modelClass)->getRouteKeyName(), $value)
                    ->first();
            });
        }
    }
}
