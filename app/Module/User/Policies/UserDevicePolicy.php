<?php

namespace App\Module\User\Policies;

use App\Module\User\Entities\UserDevice;
use App\Module\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDevicePolicy
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
        return $user->hasPermissionTo('read_all_user_devices','web');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\UserDevice  $accessed_user_device
     * @return mixed
     */
    public function view(User $user, UserDevice $accessed_user_device)
    {
        return $user->hasPermissionTo('read_all_user_devices','web');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create_user_device','web');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\UserDevice  $accessed_user_device
     * @return mixed
     */
    public function update(User $user, UserDevice $accessed_user_device)
    {
        return $user->hasPermissionTo('edit_user_device','web');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\UserDevice  $accessed_user_device
     * @return mixed
     */
    public function delete(User $user, UserDevice $accessed_user_device)
    {
        return $user->hasPermissionTo('delete_user_device','web');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\UserDevice  $accessed_user_device
     * @return mixed
     */
    public function restore(User $user, UserDevice $accessed_user_device)
    {
        return $user->hasPermissionTo('delete_user_device','web');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Module\User\Entities\User  $user
     * @param  \App\Module\User\Entities\UserDevice  $accessed_user_device
     * @return mixed
     */
    public function forceDelete(User $user, UserDevice $accessed_user_device)
    {
        return $user->hasPermissionTo('delete_user_device','web');
    }
}
