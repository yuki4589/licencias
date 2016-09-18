<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(CityBoard\User::class, function (Faker\Generator $faker) {
    return [
      'name' => $faker->name,
      'email' => $faker->email,
      'password' => bcrypt('secret'),
      'remember_token' => str_random(10),
    ];
});

$factory->define(CityBoard\Entities\LicenseType::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 5),
        'visit' => $faker->boolean(),
      ];
  });

$factory->define(CityBoard\Entities\File::class,
  function (Faker\Generator $faker) {
      $image = base_path('tests/file/cat.jpg');

      $name = time() . 'image' . $faker->unique()
          ->numberBetween(1, 10000) . '.jpg';
      $mimeType = 'image/jpg';

      Storage::put(
        $name,
        file_get_contents($image)
      );

      return [
        'filename' => $name,
        'mime_type' => $mimeType,
      ];
  });

$factory->define(CityBoard\Entities\Activity::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->word,
      ];
  });

$factory->define(CityBoard\Entities\Archive::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->sentence($nbWords = 3),
        'place' => $faker->word . " " . $faker->numberBetween(1, 2000),
      ];
  });
$factory->define(CityBoard\Entities\Street::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->streetAddress
      ];

  });
$factory->define(CityBoard\Entities\License::class,
  function (Faker\Generator $faker) {
      $activity_id = CityBoard\Entities\Activity::all()->random()->id;
      $archive_id = CityBoard\Entities\Archive::all()->random()->id;
      $street_id = CityBoard\Entities\Street::all()->random()->id;
      $license_type_id = CityBoard\Entities\LicenseType::all()->random()->id;
      $titular_id = CityBoard\Entities\Titular::all()->random()->id;
      if ($license_type_id == 3) {
        $visit_status = $faker->randomElement(['Solicitud puesta en marcha', 'Visita', 'Completado']);
      } else {
        $visit_status = null;
      }
      return [
        'activity_id' => $activity_id,
        'archive_id' => $archive_id,
        'license_type_id' => $license_type_id,
        'titular_id' => $titular_id,
        'expedient_number' => $faker->word,
        'register_number' => $faker->year . "/" . $faker->numberBetween(1,
            2000),
        'register_date' => $faker->date(),
        'finished' => false,
        'street_id' => $street_id,
        'street_number' => $faker->numberBetween(1, 100),
        'postcode' => env('DEFAULT_POSTCODE'),
        'city' => $faker->city,
        'archive_location' => mb_strtoupper($faker->randomLetter),
        'year' => $faker->year,
        'number' => $faker->numberBetween(1, 2000),
        'identifier' => null,
        'license_status_id' => null,
        'visit_status' => $visit_status,
        'closet' => 'A',
        'volume_year' => null,
        'on_query' => false,
      ];
  });

$factory->define(CityBoard\Entities\Titular::class,
  function (Faker\Generator $faker) {
      $nif = "";
      for ($i = 0; $i < 8; $i++) {
          $nif .= $faker->numberBetween(0, 9);
      }
      return [
        'nif' => $nif . mb_strtoupper($faker->randomLetter),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->email,
      ];
  });

$factory->define(CityBoard\Entities\UserType::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->word,
      ];
  });

$factory->define(CityBoard\Entities\PersonPosition::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->word,
      ];
  });

$factory->define(CityBoard\Entities\Person::class,
  function (Faker\Generator $faker) {
      $person_position_id = CityBoard\Entities\PersonPosition::all()->random()->id;
      return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'person_position_id' => $person_position_id,
      ];
  });

$factory->define(CityBoard\Entities\Loan::class,
  function (Faker\Generator $faker) {
      $license_id = CityBoard\Entities\License::all()->random()->id;
      $person_id = CityBoard\Entities\Person::all()->random()->id;
      $date = $faker->date();
      $date_datetime = date_create($date);
      $timeInterval = date_interval_create_from_date_string('10 days');
      $giving_back_date = date_add($date_datetime, $timeInterval);
      return [
        'license_id' => $license_id,
        'person_id' => $person_id,
        'loan_date' => $date,
        'giving_back_date' => $giving_back_date,
      ];
  });

$factory->define(CityBoard\Entities\Denunciation::class,
  function (Faker\Generator $faker) {
      $license_id = CityBoard\Entities\License::all()->random()->id;
      $file_id = CityBoard\Entities\File::all()->random()->id;
      return [
        'license_id' => $license_id,
        'register_date' => $faker->date(),
        'expedient_number' => $faker->year . "/" . $faker->numberBetween(1,
            2000),
        'reason' => $faker->sentence(),
        'file_id' => $file_id,
      ];
  });

$factory->define(CityBoard\Entities\TitularityChange::class,
  function (Faker\Generator $faker) {
      $license_id = CityBoard\Entities\License::all()->random()->id;
      $titular_id = CityBoard\Entities\Titular::all()->random()->id;
      $file_id = CityBoard\Entities\File::all()->random()->id;
      $initial_status = 'Solicitado';
      return [
        'license_id' => $license_id,
        'titular_id' => $titular_id,
        'expedient_number' => $faker->year . "/" . $faker->numberBetween(1,
            2000),
        'register_number' => $faker->year . "/" . $faker->numberBetween(1,
            2000),
        'register_date' => $faker->date(),
        'finished' => $faker->boolean(),
        'finished_date' => $faker->date(),
        'status' => $initial_status,
        'file_id' => $file_id,
      ];
  });

$factory->define(CityBoard\Entities\LicenseStatus::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->name,
        'initial' => $faker->boolean(),
        'reopen' => $faker->boolean(),
        'identifier' => $faker->boolean(),
        'success' => $faker->boolean(),
        'reject' => $faker->boolean(),
      ];
  });

$factory->define(CityBoard\Entities\LicenseStatusChange::class,
  function (Faker\Generator $faker) {
      $license_id = CityBoard\Entities\License::all()->random()->id;
      $license_status_id = CityBoard\Entities\LicenseStatus::all()->random()->id;
      return [
        'license_id' => $license_id,
        'license_status_id' => $license_status_id,
        'change_date' => $faker->date(),
      ];
  });

$factory->define(CityBoard\Entities\TimeLimit::class,
  function (Faker\Generator $faker) {
      return [
        'weight' => $faker->numberBetween(1, 100),
        'days' => $faker->numberBetween(1, 100),
      ];
  });

$factory->define(CityBoard\Entities\Objection::class,
  function (Faker\Generator $faker) {
      $license_id = CityBoard\Entities\License::all()->random()->id;
      $license_stage_id = CityBoard\Entities\LicenseStage::all()->random()->id;
      $license_current_stage_id = CityBoard\Entities\LicenseCurrentStage::all()->random()->id;
      $first_person_position_id = CityBoard\Entities\PersonPosition::all()->random()->id;
      $second_person_position_id = null;
      $add_second_person_position = $faker->boolean();
      if ($add_second_person_position) {
          $second_person_position = CityBoard\Entities\PersonPosition::where('id',
            $first_person_position_id + 1)->first();
          if (is_null($second_person_position_id)) {
              $second_person_position_id = CityBoard\Entities\PersonPosition::where('id',
                $first_person_position_id - 2)->first();
          }
          if (!is_null($second_person_position_id)) {
              $second_person_position_id = $second_person_position->id;
          }
      }
      $file_id = CityBoard\Entities\File::all()->random()->id;
      return [
        'license_current_stage_id' => $license_current_stage_id,
        'license_id' => $license_id,
        'license_stage_id' => $license_stage_id,
        'first_person_position_id' => $first_person_position_id,
        'second_person_position_id' => $second_person_position_id,
        'report_date' => $faker->date(),
        'correction_date' => $faker->date(),
        'file_id' => $file_id,
      ];
  });

$factory->define(CityBoard\Entities\ObjectionNotification::class,
  function (Faker\Generator $faker) {
      $objection_id = CityBoard\Entities\Objection::all()->random()->id;
      $time_limit_id = CityBoard\Entities\TimeLimit::all()->random()->id;
      return [
        'objection_id' => $objection_id,
        'time_limit_id' => $time_limit_id,
        'notification_date' => $faker->date(),
        'finish_date' => $faker->date(),
      ];
  });

$factory->define(CityBoard\Entities\LicenseStage::class,
  function (Faker\Generator $faker) {
      return [
        'name' => $faker->sentence(2),
        'date' => $faker->boolean(),
        'person' => $faker->boolean(),
        'number' => $faker->boolean(),
        'file' => $faker->boolean(),
        'objection' => $faker->boolean(),
      ];
  });

$factory->define(CityBoard\Entities\LicenseTypeStage::class,
  function (Faker\Generator $faker) {
      $license_type_id = CityBoard\Entities\LicenseType::all()->random()->id;
      $license_stages = CityBoard\Entities\LicenseStage::all();
      $license_stage_id = $faker->numberBetween(1, count($license_stages));
      $license_previous_id = $license_stage_id - 1;

      if ($license_previous_id == 0) {
          $license_previous_id = null;
      }

      $license_next_id = $license_stage_id + 1;
      $license_generate = false;

      if (is_null(CityBoard\Entities\LicenseStage::find($license_next_id))) {
          $license_type_stage_license_next_id = null;
          $license_generate = true;
      }
      return [
        'license_type_id' => $license_type_id,
        'license_stage_id' => $license_stage_id,
        'weight' => $faker->unique()->randomNumber(),
        'previous' => $license_previous_id,
        'next' => $license_next_id,
        'license_generate' => $license_generate,
      ];
  });

$factory->define(CityBoard\Entities\LicenseCurrentStage::class,
  function (Faker\Generator $faker) {
      $license_id = CityBoard\Entities\License::all()->random()->id;

      $license_stages = CityBoard\Entities\LicenseStage::all();
      $license_stage_id = $faker->numberBetween(1, count($license_stages));

      $license_previous_id = $license_stage_id - 1;

      if ($license_previous_id == 0) {
          $license_previous_id = null;
      }

      $license_next_id = $license_stage_id + 1;
      $license_generate = false;

      if (is_null(CityBoard\Entities\LicenseStage::find($license_next_id))) {
          $license_next_id = null;
          $license_generate = true;
      }

      $person_id = CityBoard\Entities\Person::all()->random()->id;
      $file_id = CityBoard\Entities\File::all()->random()->id;
      $objection_id = null;
      return [
        'license_id' => $license_id,
        'license_stage_id' => $license_stage_id,
        'weight' => $faker->randomNumber(),
        'date' => $faker->date(),
        'person_id' => $person_id,
        'number' => $faker->randomNumber(),
        'file_id' => $file_id,
        'objection_id' => $objection_id,
        'previous' => $license_previous_id,
        'next' => $license_next_id,
        'license_generate' => $license_generate
      ];
  });
