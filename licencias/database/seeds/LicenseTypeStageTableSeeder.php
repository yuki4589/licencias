<?php

use Illuminate\Database\Seeder;

class LicenseTypeStageTableSeeder extends Seeder {

  public function run() {
    // Tipo 1 - Comunicado de Actividad

    $stagesTypeOne = [
      1,
      2,
      12,
      13,
      14,
      15,
      16
    ];

    $this->createStages($stagesTypeOne, 1);

    // Tipo 2 Licencias Sin Calificación

    $stagesTypeTwo = [
      1,
      2,
      7,
      8,
      13,
      14,
      15,
      16
    ];

    $this->createStages($stagesTypeTwo, 2);

    // Tipo 3 Licencias Con Calificación

    $stagesTypeThree = [
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      8,
      9,
      10,
      11,
      12,
      13,
      14,
      15,
      16
    ];

    $this->createStages($stagesTypeThree, 3);

  }

  /**
   * @param $stages
   * @param $licenseType
   */
  private function createStages($stages, $licenseType) {
    $weight = 0;
    foreach ($stages as $stage) {
      if ($weight != 0) {
        $licenseTypeStagePrevious = CityBoard\Entities\LicenseTypeStage::where('license_type_id',
          $licenseType)->where('weight', $weight - 1)->first();
      }
      $licenseTypeStage = new CityBoard\Entities\LicenseTypeStage();
      $licenseTypeStage->license_type_id = $licenseType;
      $licenseTypeStage->license_stage_id = $stage;
      $licenseTypeStage->weight = $weight;

      $licenseTypeStage->previous = NULL;
      if ($weight != 0) {
        $licenseTypeStage->previous = $licenseTypeStagePrevious->license_stage_id;
      }

      $licenseTypeStage->next = NULL;
      if ($weight != 0) {
        $licenseTypeStagePrevious->next = $stage;
        $licenseTypeStagePrevious->save();
      }

      $licenseTypeStage->license_generate = TRUE;
      if ($weight != 0) {
        $licenseTypeStagePrevious->license_generate = FALSE;
        $licenseTypeStagePrevious->save();
      }

      $licenseTypeStage->save();
      $weight++;
    }
  }
}
