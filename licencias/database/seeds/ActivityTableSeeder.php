<?php

use Illuminate\Database\Seeder;
use CityBoard\Entities\Activity;

class ActivityTableSeeder extends Seeder
{

    public function run()
    {
        factory(Activity::class)->create([
          'name' => 'Bar',
        ]);
        factory(Activity::class)->create([
          'name' => 'Industria',
        ]);
        factory(Activity::class)->create([
          'name' => 'Academia',
        ]);
    }
}
