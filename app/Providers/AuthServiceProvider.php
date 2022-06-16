<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('admin' , function (User $user) {
            foreach ($user->roles()->get() as $role) {
                if ($role->role === 'admin')
                    return true;
            }
            return false;
        });

        Gate::define('writer' , function (User $user) {
            foreach ($user->roles()->get() as $role) {
                if ($role->role === 'writer' || $role->role === 'admin')
                    return true;
            }
            return false;
        });

        Gate::define('editor' , function (User $user) {
            foreach ($user->roles()->get() as $role) {
                if ($role->role === 'editor')
                    return true;
            }
            return false;
        });
    }
}
