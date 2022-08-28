<?php

namespace App\Module\User\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Module\User\Entities\UserDevice;

class UserDeviceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(UserDevice::class,1000)->create();
    }
}
