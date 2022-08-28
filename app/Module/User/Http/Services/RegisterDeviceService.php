<?php

namespace App\Module\User\Http\Services;

use App\Module\User\Entities\User;

/**
 * Class RegisterDeviceService.
 *
 * @package namespace App\Domain\User\Services;
 */
class RegisterDeviceService {



    /**
     * @param User $user
     * @param string $type
     * @param String|null $firebase_token
     * @param String|null $platform
     * @return  UserDevice|null $device
     */
    public function register(User $user, String $firebase_token = null, String $platform = null): ?UserDevice
    {
        if ($firebase_token!=null&$user!=null) {
            $device = UserDevice::Where('firebase_token' , $firebase_token)->first();
            if (!$device) {
                $device = UserDevice::create(['user_id' => $user->id, 'type' => $platform, 'firebase_token' => $firebase_token]);
            } else if ($device->user_id != $user->id) {
                $device = UserDevice::update(['user_id' => $user->id], $device->id);
            }
            return $device;
        }
        return null;
    }
}
