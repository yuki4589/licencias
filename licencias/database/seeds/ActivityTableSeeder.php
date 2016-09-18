<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Activity::class)->create([
          'name' => 'Bar',
        ]);

        factory(CityBoard\Entities\Activity::class)->create([
          'name' => 'Industria',
        ]);
        factory(CityBoard\Entities\Activity::class)->create([
          'name' => 'Academia',
        ]);
    }
}
