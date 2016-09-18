<?php

use Illuminate\Database\Seeder;

class ObjectionTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Objection::class, 30)->create();
    }
}
