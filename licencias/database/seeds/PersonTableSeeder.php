<?php

use Illuminate\Database\Seeder;

class PersonTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Person::class, 2)->create();
    }
}
