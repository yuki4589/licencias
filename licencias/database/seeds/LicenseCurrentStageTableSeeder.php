<?php

use Illuminate\Database\Seeder;

class LicenseCurrentStageTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\LicenseCurrentStage::class, 180)->create();
    }
}
