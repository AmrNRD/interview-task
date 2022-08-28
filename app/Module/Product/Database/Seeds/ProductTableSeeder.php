<?php

namespace App\Module\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Module\Product\Entities\Product;

class ProductTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class,1000)->create();
    }
}
