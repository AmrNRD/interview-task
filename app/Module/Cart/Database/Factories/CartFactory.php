<?php

namespace App\Module\Cart\Database\Factories;

use App\Module\Cart\Entities\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Module\User\Entities\User;


class CartFactory extends Factory
{

    public function definition()
    {

        return [
		'user_id'=> factory(User::class)->create()->id,

        ];
    }

    protected $model=Cart::class;
}
