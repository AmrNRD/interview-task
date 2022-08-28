<?php

namespace App\Module\User\Policies;


use App\Module\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user->hasPermissionTo('read_all_users','web');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\User  $accessed_user
     * @return mixed
     */
    public function view(User $user, User $accessed_user)
    {
        return $user->hasPermissionTo('read_all_users','web');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create_user','web');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\User  $accessed_user
     * @return mixed
     */
    public function update(User $user, User $accessed_user)
    {
        return $user->hasPermissionTo('edit_user','web');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\User  $accessed_user
     * @return mixed
     */
    public function delete(User $user, User $accessed_user)
    {
        return $user->hasPermissionTo('delete_user','web');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\User  $accessed_user
     * @return mixed
     */
    public function restore(User $user, User $accessed_user)
    {
        return $user->hasPermissionTo('delete_user','web');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\User  $accessed_user
     * @return mixed
     */
    public function forceDelete(User $user, User $accessed_user)
    {
        return $user->hasPermissionTo('delete_user','web');
    }
}
