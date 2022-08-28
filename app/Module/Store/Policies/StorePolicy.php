<?php

namespace App\Module\Store\Policies;

use App\Module\Store\Entities\Store;
use App\Module\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
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
        return $user->hasPermissionTo('read_all_stores','web');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Store\Entities\Store  $accessed_store
     * @return mixed
     */
    public function view(User $user, Store $accessed_store)
    {
        return $user->hasPermissionTo('read_all_stores','web');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create_store','web');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Store\Entities\Store  $accessed_store
     * @return mixed
     */
    public function update(User $user, Store $accessed_store)
    {
        return $user->hasPermissionTo('edit_store','web');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Store\Entities\Store  $accessed_store
     * @return mixed
     */
    public function delete(User $user, Store $accessed_store)
    {
        return $user->hasPermissionTo('delete_store','web');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Store\Entities\Store  $accessed_store
     * @return mixed
     */
    public function restore(User $user, Store $accessed_store)
    {
        return $user->hasPermissionTo('delete_store','web');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\Store\Entities\Store  $accessed_store
     * @return mixed
     */
    public function forceDelete(User $user, Store $accessed_store)
    {
        return $user->hasPermissionTo('delete_store','web');
    }
}
