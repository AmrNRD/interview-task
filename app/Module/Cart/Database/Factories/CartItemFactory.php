<?php

namespace App\Module\Cart\Database\Factories;

use App\Module\Cart\Entities\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use \App\Module\Cart\Entities\Cart;
use \App\Module\Product\Entities\Product;


class CartItemFactory extends Factory
{

    public function definition()
    {

        return [
		'cart_id'=> factory(Cart::class)->create()->id,
		'product_id'=> factory(Product::class)->create()->id,

        ];
    }

    protected $model=CartItem::class;
}
