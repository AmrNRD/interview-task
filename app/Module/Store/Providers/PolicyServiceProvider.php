<?php

namespace App\Module\Store\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Module\Store\Entities\Store::class => \App\Module\Store\Policies\StorePolicy::class,
		\App\Module\Store\Entities\Store::class => \App\Module\Store\Policies\StorePolicy::class,
		\App\Module\Store\Entities\Store::class => \App\Module\Store\Policies\StorePolicy::class,
		\App\Module\Store\Entities\Store::class => \App\Module\Store\Policies\StorePolicy::class,
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
