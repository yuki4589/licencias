<?php

use CityBoard\Entities\Activity;
use CityBoard\Entities\Archive;
use CityBoard\Entities\License;
use CityBoard\Entities\LicenseType;
use CityBoard\Entities\Titular;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DenunciationTest extends TestCase
{
    use DatabaseTransactions;

    private $create_data;
    private $change_data;
    private $identifier_field;
    private $identifier_field_value;
    private $last_page;
    private $text_create_button;
    private $text_edit_button;
    private $text_submit_changes_button;
    private $resource;
    private $entity_table;
    private $name_of_field_for_file;
    private $absolute_path_to_file;

    public function initialize()
    {

        $this->activity = factory(Activity::class)->create();
        $this->archive = factory(Archive::class)->create();
        $this->licenseType = factory(LicenseType::class)->create();
        $this->titular = factory(Titular::class)->create();
        $this->license = factory(License::class, 3)->create();

        $this->resource = 'denunciation';
        $this->entity_table = 'denunciations';

        $this->name_of_field_for_file = 'filename';
        $this->absolute_path_to_file = base_path('tests/file') . '/cat.jpg';

        $this->create_data = [
          'license_id' => 2,
          'register_date' => '2012-02-28',
          'expedient_number' => '123#12345678',
        ];

        $this->change_data = [
          'license_id' => 3,
          'register_date' => '2012-03-01',
          'expedient_number' => '123#12345678',
        ];

        $this->identifier_field = 'expedient_number';

        $this->identifier_field_value = $this->create_data[$this->identifier_field];

        $this->text_create_button = 'Crear Denuncia';

        $this->text_edit_button = 'Editar';

        $this->text_submit_changes_button = 'Guardar cambios en Denuncia';

    }

    private function obtain_id_for_create_resource()
    {
        $this->initialize();

        return CityBoard\Entities\Denunciation::where($this->identifier_field,
          $this->identifier_field_value)->first()->id;
    }

    public function test_denunciation_routes()
    {
        $this->initialize();

        $this->visit(route($this->resource . '.create'))
          ->select(2, 'license_id')
          ->type('10122015', 'register_date')
          ->type('123#12345678', 'expedient_number')
          ->attach($this->absolute_path_to_file, $this->name_of_field_for_file)
          ->press($this->text_create_button);
        $resource_id = $this->obtain_id_for_create_resource();
        $this->visit($this->resource)
          ->see($this->identifier_field_value);
        $this->visit(route($this->resource . '.edit',
          [$this->resource => $resource_id]))
          ->see($this->identifier_field_value);
        $this->visit(route($this->resource . '.show',
          [$this->resource => $resource_id]))
          ->see($this->identifier_field_value);

    }

    public function test_denunciation_create_edit()
    {
        $this->initialize();

        $this->visit(route($this->resource . '.create'))
          ->select(2, 'license_id')
          ->type('2015-12-10', 'register_date')
          ->type('123#12345678', 'expedient_number')
          ->attach($this->absolute_path_to_file, $this->name_of_field_for_file)
          ->press($this->text_create_button)
          ->seeInDatabase($this->entity_table, [
            'license_id' => 2,
            'register_date' => '2015-12-10',
            'expedient_number' => '123#12345678',
          ])
          ->click($this->text_edit_button)
          ->select(2, 'license_id')
          ->type('2015-12-11', 'register_date')
          ->type('123#123456789', 'expedient_number')
          ->attach($this->absolute_path_to_file, $this->name_of_field_for_file)
          ->press($this->text_submit_changes_button)
          ->seeInDatabase($this->entity_table, [
            'license_id' => 2,
            'register_date' => '2015-12-11',
            'expedient_number' => '123#123456789',
          ]);

    }
}