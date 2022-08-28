<?php

namespace App\Module\Product\Policies;

use App\Module\Product\Entities\Product;
use App\Module\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
        return $user->hasPermissionTo('read_all_products','web');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Product\Entities\Product  $accessed_product
     * @return mixed
     */
    public function view(User $user, Product $accessed_product)
    {
        return $user->hasPermissionTo('read_all_products','web');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create_product','web');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Product\Entities\Product  $accessed_product
     * @return mixed
     */
    public function update(User $user, Product $accessed_product)
    {
        return $user->hasPermissionTo('edit_product','web');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Product\Entities\Product  $accessed_product
     * @return mixed
     */
    public function delete(User $user, Product $accessed_product)
    {
        return $user->hasPermissionTo('delete_product','web');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Product\Entities\Product  $accessed_product
     * @return mixed
     */
    public function restore(User $user, Product $accessed_product)
    {
        return $user->hasPermissionTo('delete_product','web');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Product\Entities\Product  $accessed_product
     * @return mixed
     */
    public function forceDelete(User $user, Product $accessed_product)
    {
        return $user->hasPermissionTo('delete_product','web');
    }
}
