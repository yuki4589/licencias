<?php

use Illuminate\Database\Seeder;

class LicenseStatusTableSeeder extends Seeder {

  public function run() {
    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Solicitada',
      'initial' => TRUE,
      'reopen' => FALSE,
      'identifier' => FALSE,
      'success' => FALSE,
      'reject' => FALSE,
    ]);

    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Modificada',
      'initial' => FALSE,
      'reopen' => TRUE,
      'identifier' => FALSE,
      'success' => FALSE,
      'reject' => FALSE,
    ]);
    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Concedida',
      'initial' => FALSE,
      'reopen' => FALSE,
      'identifier' => TRUE,
      'success' => TRUE,
      'reject' => FALSE,
    ]);

    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Caducada',
      'initial' => FALSE,
      'reopen' => FALSE,
      'identifier' => FALSE,
      'success' => TRUE,
      'reject' => FALSE,
    ]);

    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Denegada',
      'initial' => FALSE,
      'reopen' => FALSE,
      'identifier' => FALSE,
      'success' => FALSE,
      'reject' => TRUE,
    ]);

    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Desistida',
      'initial' => FALSE,
      'reopen' => FALSE,
      'identifier' => FALSE,
      'success' => FALSE,
      'reject' => TRUE,
    ]);

    factory(CityBoard\Entities\LicenseStatus::class)->create([
      'name' => 'Renuncia',
      'initial' => FALSE,
      'reopen' => FALSE,
      'identifier' => FALSE,
      'success' => FALSE,
      'reject' => TRUE,
    ]);
  }
}
