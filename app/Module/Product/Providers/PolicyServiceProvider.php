<?php

namespace App\Module\Product\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Module\Product\Entities\Product::class => \App\Module\Product\Policies\ProductPolicy::class,
		\App\Module\Product\Entities\Product::class => \App\Module\Product\Policies\ProductPolicy::class,
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
