<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TrashedRouteBindingServiceProvider extends ServiceProvider
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
        // Ensure that routes are fully registered by waiting until the app has booted.
        $this->app->booted(function () {
            // Define the route parameter names that should use soft-deleted binding.
            $trashedParameters = ['user', 'post', 'comment', 'article', 'category'];

            // Loop through all registered routes.
            foreach (Route::getRoutes() as $route) {
                // If any of the route's parameters match those in the list, apply trashed bindings.
                if (count(array_intersect($route->parameterNames(), $trashedParameters)) > 0) {
                    $route->withTrashed();
                }
            }
        });
    }
}
