<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        Gate::define('roleAdmin', function($user){
            return $user->role ==User::USER_ROLE_ADMIN;
        });
        //
        Gate::define('roleMhs',function($user){
            return $user->role ==User::USER_ROLE_MHS;
        });
        Gate::define('roleDosen',function($user){
            return $user->role ==User::USER_ROLE_DOSEN;
        });
    }
}
