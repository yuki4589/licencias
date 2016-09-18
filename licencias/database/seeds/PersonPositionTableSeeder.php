<?php

use Illuminate\Database\Seeder;

class PersonPositionTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\PersonPosition::class)->create([
          'name' => 'Arquitecto',
        ]);

        factory(CityBoard\Entities\PersonPosition::class)->create([
          'name' => 'Ingeniero',
        ]);

        factory(CityBoard\Entities\PersonPosition::class)->create([
          'name' => 'Ambientólogo',
        ]);
    }
}
