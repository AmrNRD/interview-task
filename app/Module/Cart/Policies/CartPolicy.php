<?php

namespace App\Module\Cart\Policies;

use App\Module\Cart\Entities\Cart;
use App\Module\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('read_all_carts','web');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Cart\Entities\Cart  $accessed_cart
     * @return mixed
     */
    public function view(User $user, Cart $accessed_cart)
    {
        return $user->hasPermissionTo('read_all_carts','web');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create_cart','web');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Cart\Entities\Cart  $accessed_cart
     * @return mixed
     */
    public function update(User $user, Cart $accessed_cart)
    {
        return $user->hasPermissionTo('edit_cart','web');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Cart\Entities\Cart  $accessed_cart
     * @return mixed
     */
    public function delete(User $user, Cart $accessed_cart)
    {
        return $user->hasPermissionTo('delete_cart','web');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Cart\Entities\Cart  $accessed_cart
     * @return mixed
     */
    public function restore(User $user, Cart $accessed_cart)
    {
        return $user->hasPermissionTo('delete_cart','web');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Cart\Entities\Cart  $accessed_cart
     * @return mixed
     */
    public function forceDelete(User $user, Cart $accessed_cart)
    {
        return $user->hasPermissionTo('delete_cart','web');
    }
}
