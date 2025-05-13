<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;

class AuthorizeServiceProvider extends ServiceProvider
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
        // Log initialization
        Log::info("AuthorizeProvider boot method initialized.");
    

       Gate::before(function ($user, $permission) {
    // Only run this logic for Admins
    if ($user instanceof \App\Models\Admin) {
        Log::info("Checking permission for admin: {$user->id}, permission: {$permission}");

        if ($user->isSuperAdmin()) {
            Log::info("Admin {$user->id} is super admin. Granting all permissions.");
            return true;
        }

        return $user->hasPermission($permission);
    }

    // If not Admin, skip and let Laravel handle it
    return null;
});

    }
    
}
