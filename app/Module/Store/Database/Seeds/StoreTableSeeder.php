<?php

namespace App\Module\Store\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Module\Store\Entities\Store;

class StoreTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Store::class,1000)->create();
    }
}
