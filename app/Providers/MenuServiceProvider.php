<?php

namespace App\Providers;

use App\Models\MenuItems;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
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
        view()->composer('*', function ($view) {
            $user = Auth::user();
            //Log::info('Authenticated User:', ['user' => $user]);
            if (!$user) {
                //Log::info('No authenticated user. Returning empty navItems.');
                $view->with('navItems', collect());
                return;
            }
        
            $roleIds = $user->roles->pluck('id');
            //Log::info('User Roles:', ['role_ids' => $roleIds]);
            $navItems = MenuItems::with(['children' => function ($query) use ($roleIds) {
                    $query->whereHas('roles', function ($query) use ($roleIds) {
                        $query->whereIn('spatie_roles.id', $roleIds);
                    });
                }])
                ->whereHas('roles', function ($query) use ($roleIds) {
                    $query->whereIn('spatie_roles.id', $roleIds);
                })
                ->whereNull('parent_id')
                ->get();
        
            //Log::info('Fetched Menu Items:', ['nav_items' => $navItems]);
            $view->with('navItems', $navItems);
        });
    }
}
