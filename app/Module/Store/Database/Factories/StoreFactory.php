<?php

namespace App\Module\Store\Database\Factories;

use App\Module\Store\Entities\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Module\User\Entities\User;


class StoreFactory extends Factory
{

    public function definition()
    {

        return [
		'name'=>$this->faker->name,
		'user_id'=> factory(User::class)->create()->id,
		'shipping_cost'=>$this->faker->randomFloat(5),
		'vat_cost'=>$this->faker->randomFloat(5),

        ];
    }

    protected $model=Store::class;
}
