<?php

use Illuminate\Database\Seeder;

class StreetTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Street::class, 100)->create();
    }
}
