<?php

use CityBoard\Entities\Activity;
use CityBoard\Entities\Archive;
use CityBoard\Entities\License;
use CityBoard\Entities\LicenseStatus;
use CityBoard\Entities\LicenseType;
use CityBoard\Entities\Titular;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LicenseTest extends TestCase
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

    private $activity;
    private $archive;
    private $licenseType;
    private $titular;
    private $license;
    private $generate_data;
    private $licenseInitialStatus;

    public function setUp(){
        parent::setUp();
        $this->initialize();
    }
    public function initialize() {
        $this->statusInitialize();
        $licenseStatusRepository = new \CityBoard\Repositories\LicenseStatusRepository();        
        $this->licenseInitialStatus = $licenseStatusRepository->initial();
        
        $this->activity = factory(Activity::class)->create();
        $this->archive = factory(Archive::class)->create();
        $this->licenseType = factory(LicenseType::class)->create();

        $this->titular = factory(Titular::class)->create();
        $this->license = factory(License::class)->create();
    }

    private function statusInitialize(){
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
    
    public function data() {
        $this->resource = 'license';
        $this->entity_table = 'licenses';

        $this->identifier_field = 'expedient_number';

        $this->identifier_field_value = $this->create_data[$this->identifier_field];

        $this->text_create_button = 'Crear licencia';

        $this->text_edit_button = 'Editar';

        $this->text_submit_changes_button = 'Guardar cambios';        
        
        $this->create_data = [
          'license_type_id' => $this->licenseType->id,
          'expedient_number' => '123456#12345678',
          'register_date' => '2016-01-22',
          'register_number' => '1234ABCEF',
          'activity_id' => $this->activity->id,
          'street' => 'C/Romero García',
          'street_number' => '16, 4º A',
          'postcode' => '12345',
          'city' => 'Cieza',
          'titular_id' => $this->titular->id,
        ];

        $this->generate_data = [
          'license_status_id' => $this->licenseInitialStatus->id,
        ];

        $this->change_data = [
          'license_type_id' => $this->licenseType->id,
          'expedient_number' => '123456#12345678',
          'register_date' => '2016-01-22',
          'register_number' => '1234ABCEF',
          'activity_id' => $this->activity->id,
          'street' => 'C/Romero García',
          'street_number' => '16, 4º A',
          'postcode' => '12345',
          'city' => 'Cieza',
          'titular_id' => $this->titular->id,
          'archive_id' => $this->archive->id,
          'archive_location' => 'B',
        ];
    }

    private function obtain_id_for_create_resource()
    {
        $this->data();

        return CityBoard\Entities\License::where($this->identifier_field,
          $this->identifier_field_value)->first()->id;
    }

    public function test_license_routes()
    {
        $this->data();

        $this->visit(route($this->resource . '.create'))
          ->submitForm($this->text_create_button, $this->create_data);
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

    public function test_license_create_edit()
    {
        $this->data();
        
        $this->visit(route($this->resource . '.create'))
          ->submitForm($this->text_create_button, $this->create_data)
          ->seeInDatabase($this->entity_table, $this->create_data)
          ->seeInDatabase($this->entity_table, $this->generate_data);
        $resource_id = $this->obtain_id_for_create_resource();
        $this->seeInDatabase(
            'license_status_changes',
            [
              'license_id' => $resource_id,
              'license_status_id' => $this->licenseInitialStatus->id,
            ]
          );
        $this->visit(route(
          $this->resource . '.edit',
          [$this->resource => $resource_id]
        ))
          ->submitForm($this->text_submit_changes_button, $this->change_data)
          ->seeInDatabase($this->entity_table, $this->change_data);

    }
}