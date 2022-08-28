<?php

namespace App\Module\User\Database\Factories;

use App\Module\User\Entities\UserDevice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Module\User\Entities\User;


class UserDeviceFactory extends Factory
{

    public function definition()
    {

        return [
		'fcm_token'=>$this->faker->text,
		'type'=> 'ios',
		'user_id'=> factory(User::class)->create()->id,

        ];
    }

    protected $model=UserDevice::class;
}
