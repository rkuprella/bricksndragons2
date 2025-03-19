<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blade::directive('role', function ($role) {
            return "<?php 
                \$roleHierarchy = [
                    'user' => 1,
                    'editor' => 2,
                    'admin' => 3,
                ];
                if (Auth::check() && isset(\$roleHierarchy[Auth::user()->role]) && \$roleHierarchy[Auth::user()->role] >= \$roleHierarchy[$role]): 
            ?>";
        });
    
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
