<?php

namespace App\Module\User\Http\Services;

use App\Module\User\Entities\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterDeviceService.
 *
 * @package namespace App\Domain\User\Services;
 */
class RegisterUserService
{


    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        if(Arr::has($data,'password')&&$data['password']!=null){
            $data['password'] = Hash::make($data['password']);
        }
        $user = User::create($data);
        return $user;
    }


}
