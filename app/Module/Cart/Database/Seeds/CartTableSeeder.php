<?php

namespace App\Module\Cart\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Module\Cart\Entities\Cart;

class CartTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Cart::class,1000)->create();
    }
}
