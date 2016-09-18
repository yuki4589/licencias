<?php

use Illuminate\Database\Seeder;

class LicenseTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\License::class, 100)->create(['license_status_id' => 1]);
    }
}
