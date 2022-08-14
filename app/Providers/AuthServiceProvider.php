<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('Product_list', 'App\Policies\ProductPolicy@view');
        // Gate::define('Product_list', function ($user) {
        //    return $user->checkPermissionAccess('Product_list');
        // });
        Gate::define('Product_add', 'App\Policies\ProductPolicy@create');

        Gate::define('Product_edit', 'App\Policies\ProductPolicy@update');

        Gate::define('Product_delete', 'App\Policies\ProductPolicy@delete');

        //  quan ly role
        Gate::define('Role_list', 'App\Policies\RolePolicy@view');
        Gate::define('Role_add', 'App\Policies\RolePolicy@create');
        Gate::define('Role_edit', 'App\Policies\RolePolicy@update');
        Gate::define('Role_delete', 'App\Policies\RolePolicy@delete');

        //quan ly user
        Gate::define('User_list', 'App\Policies\UserPolicy@view');
        Gate::define('User_add', 'App\Policies\UserPolicy@create');
        Gate::define('User_edit', 'App\Policies\UserPolicy@update');
        Gate::define('User_delete', 'App\Policies\UserPolicy@delete');

        //quan ly page
        Gate::define('Page_list', 'App\Policies\PagePolicy@view');
        Gate::define('Page_add', 'App\Policies\PagePolicy@create');
        Gate::define('Page_edit', 'App\Policies\PagePolicy@update');
        Gate::define('Page_delete', 'App\Policies\PagePolicy@delete');

        //quan ly Post
        Gate::define('Post_list', 'App\Policies\PostPolicy@view');
        Gate::define('Post_add', 'App\Policies\PostPolicy@create');
        Gate::define('Post_edit', 'App\Policies\PostPolicy@update');
        Gate::define('Post_delete', 'App\Policies\PostPolicy@delete');

         //quan ly Order
         Gate::define('Order_list', 'App\Policies\OrderPolicy@view');

           //quan ly slider
        Gate::define('Slider_list', 'App\Policies\SliderPolicy@view');
        Gate::define('Slider_delete', 'App\Policies\SliderPolicy@delete');
    }
}
