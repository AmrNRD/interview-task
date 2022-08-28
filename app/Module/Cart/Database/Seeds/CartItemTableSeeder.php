<?php

namespace App\Module\Cart\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Module\Cart\Entities\CartItem;

class CartItemTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(CartItem::class,1000)->create();
    }
}
