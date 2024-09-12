<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Observers\ApplicationObserver;
use App\Observers\MenuObserver;
use App\Observers\SubmenuObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
        Menu::observe(MenuObserver::class);
        MenuItem::observe(SubmenuObserver::class);
        Application::observe(ApplicationObserver::class);
    }
}
