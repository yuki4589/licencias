<?php

use Illuminate\Database\Seeder;

class TimeLimitTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\TimeLimit::class)->create([
          'weight' => 1,
          'days' => 10,
          'name' => 'Tiempo alerta reparo',
          'code' => 'LTAR',
        ]);

        factory(CityBoard\Entities\TimeLimit::class)->create([
          'weight' => 2,
          'days' => 5,
          'name' => 'Tiempo alerta reparo N2',
          'code' => 'LTARN2',
        ]);

        factory(CityBoard\Entities\TimeLimit::class)->create([
          'weight' => 3,
          'days' => 20,
          'name' => 'Tiempo alerta plazo',
          'code' => 'LTAP',
        ]);

        factory(CityBoard\Entities\TimeLimit::class)->create([
          'weight' => 4,
          'days' => 5,
          'name' => 'Tiempo alerta información pública',
          'code' => 'LTAIP',
        ]);
    }
}
