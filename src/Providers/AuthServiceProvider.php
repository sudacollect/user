<?php

namespace Gtd\Extension\User\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;


use Gtd\Extension\User\Providers\AuthUserServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('suda_user_provider', function ($app, array $config) {
            $model = $config['model'];
            return new AuthUserServiceProvider($app['hash'], $model);
        });
    }

}
