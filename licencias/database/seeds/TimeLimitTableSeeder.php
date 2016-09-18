<?php

use Illuminate\Database\Seeder;

class TimeLimitTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\TimeLimit::class)->create([
          'weight' => 1,
          'days' => 10,
        ]);

        factory(CityBoard\Entities\TimeLimit::class)->create([
          'weight' => 2,
          'days' => 5,
        ]);
    }
}
