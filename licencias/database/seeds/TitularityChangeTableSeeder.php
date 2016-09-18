<?php

use Illuminate\Database\Seeder;

class TitularityChangeTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\TitularityChange::class, 400)->create();
    }
}
