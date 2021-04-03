<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
         //Returns false if not an admin, so can:accessAdmin if no admin returns 0 from isAdmin column, therefore false
        Gate::define('accessAdmin', function($user){
            return Auth::user()->isAdmin;
        });

        //Returns false if not a vendor (see above for accessAdmin)
        Gate::define('accessVendor', function($user){
            return Auth::user()->isVendor;
        });
    }
}
