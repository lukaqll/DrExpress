<?php

namespace App\Providers;

use App\Models\Permission;
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
        'App\Models\Product' => 'App\Policies\ProductPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissionsModel = new Permission;
        $permissions = $permissionsModel->with('roles')->get();
        
        foreach($permissions as $permission){
            Gate::define($permission->slug, function (User $user) use($permission) {
                return $user->hasPermission( $permission );
            }); 
        }

        Gate::before(function(User $user){
            
            if($user->hasAnyRoles('admin'))
                return true;

            if( $user->status == 'I' )
                return false;
        });
    }
}
