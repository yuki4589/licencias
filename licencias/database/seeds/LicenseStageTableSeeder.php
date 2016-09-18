<?php

use Illuminate\Database\Seeder;

class LicenseStageTableSeeder extends Seeder
{

    public function run()
    {
        // id = 1
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Encargo Informe Urbanismo',
          'date' => true,
          'date_required' => true,
          'person' => true,
          'person_required' => true,
          'number' => false,
          'file' => false,
          'objection' => true,
          'objection_required' => false,
        ]);

        // id = 2
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Informe Urbanístico',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'file_required' => false,
          'objection' => false,
        ]);

        // id = 3
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Adminisión Trámite',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 4
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Edicto Remisión',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 5
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Edicto Recepción',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 6
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Informe Alegaciones',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => true,
          'number_required' => true,
          'file' => false,
          'file_required' => false,
          'objection' => false,
          'optional' => true,
        ]);

        // id = 7
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Encargo Informe Industrial',
          'date' => true,
          'date_required' => true,
          'person' => true,
          'person_required' => true,
          'number' => false,
          'file' => false,
          'objection' => true,
          'objection_required' => false,
        ]);

        // id = 8
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Informe Industrial',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'file_required' => false,
          'objection' => false,
        ]);

        // id = 9
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Encargo Informe Ambiental',
          'date' => true,
          'date_required' => true,
          'person' => true,
          'person_required' => true,
          'number' => false,
          'file' => false,
          'objection' => true,
          'objection_required' => false,
        ]);

        // id = 10
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Informe Ambiental',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'file_required' => false,
          'objection' => false,
        ]);

        // id = 11
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Informe De Calificación Y Propuesta De Resolución',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 12
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Número de Resolución',
          'date' => false,
          'person' => false,
          'number' => true,
          'number_required' => true,
          'file' => false,
          'objection' => false,
        ]);

        // id = 13
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Fecha de Resolución',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 14
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Entrega Notificador',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 15
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Notificación',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);

        // id = 16
        factory(CityBoard\Entities\LicenseStage::class)->create([
          'name' => 'Finalizar Licencia',
          'date' => true,
          'date_required' => true,
          'person' => false,
          'number' => false,
          'file' => false,
          'objection' => false,
        ]);
    }
}
