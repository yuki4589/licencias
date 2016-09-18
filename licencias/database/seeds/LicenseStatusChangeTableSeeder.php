<?php

use Illuminate\Database\Seeder;

class LicenseStatusChangeTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\LicenseStatusChange::class, 2)->create();
    }
}
