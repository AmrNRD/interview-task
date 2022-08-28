<?php

namespace App\Module\Cart\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Module\Cart\Entities\Cart::class => \App\Module\Cart\Policies\CartPolicy::class,
		\App\Module\Cart\Entities\CartItem::class => \App\Module\Cart\Policies\CartItemPolicy::class,
		\App\Module\Cart\Entities\Cart::class => \App\Module\Cart\Policies\CartPolicy::class,
		\App\Module\Cart\Entities\CartItem::class => \App\Module\Cart\Policies\CartItemPolicy::class,
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
