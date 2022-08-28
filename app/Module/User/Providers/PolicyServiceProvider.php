<?php

namespace App\Module\User\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Module\User\Entities\User::class => \App\Module\User\Policies\UserPolicy::class,
		\App\Module\User\Entities\UserDevice::class => \App\Module\User\Policies\UserDevicePolicy::class,
		\App\Module\User\Entities\UserDevice::class => \App\Module\User\Policies\UserDevicePolicy::class,
		###POLICIES###
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
