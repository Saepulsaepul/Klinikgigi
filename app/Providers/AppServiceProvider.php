<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // Add this import
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Define gates for role checks
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('isDokter', function ($user) {
            return $user->role === 'dokter';
        });

        Gate::define('isResepsionis', function ($user) {
            return $user->role === 'resepsionis';
        });

        Gate::define('isPasien', function ($user) {
            return $user->role === 'pasien';
        });
    }
}