<?php

use Illuminate\Database\Seeder;

class LicenseTypeTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\LicenseType::class)->create([
          'name' => 'Comunicado de actividad',
          'visit' => false,
        ]);

        factory(CityBoard\Entities\LicenseType::class)->create([
          'name' => 'Licencia sin calificación',
          'visit' => false,
        ]);

        factory(CityBoard\Entities\LicenseType::class)->create([
          'name' => 'Licencia con calificación',
          'visit' => true,
        ]);
    }
}
