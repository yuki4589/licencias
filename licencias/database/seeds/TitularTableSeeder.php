<?php

use Illuminate\Database\Seeder;

class TitularTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Titular::class, 10)->create();
    }
}
