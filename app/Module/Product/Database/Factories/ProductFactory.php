<?php

namespace App\Module\Product\Database\Factories;

use App\Module\Product\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use \App\Module\Store\Entities\Store;


class ProductFactory extends Factory
{

    public function definition()
    {

        return [
		'name'=>$this->faker->name,
		'store_id'=> factory(Store::class)->create()->id,
		'price'=>$this->faker->randomFloat(5),
		'vat_included'=>$this->faker->name,

        ];
    }

    protected $model=Product::class;
}
