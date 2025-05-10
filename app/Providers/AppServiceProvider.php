<?php

namespace App\Providers;

use App\Http\View\Composers\PostCategoryComposer;
use App\Models\Permission;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

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
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer(['inc_themes.header'], PostCategoryComposer::class);

        $site = Site::first();
        View::share('site', $site);
        
        $permissions = Permission::all();
        foreach($permissions as $permission){
            Gate::define($permission->slug,function(User $user) use ($permission){
                return $user->hasPermission($permission->slug);
            });
        }
    }
}
