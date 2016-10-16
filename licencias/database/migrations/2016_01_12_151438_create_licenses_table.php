<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('license_type_id')->unsigned();
            $table->foreign('license_type_id')
              ->references('id')
              ->on('license_types');

            $table->string('expedient_number');
            $table->date('register_date');
            $table->string('register_number');

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');

            $table->integer('street_id')->unsigned();
            $table->foreign('street_id')->references('id')->on('streets');
            $table->string('street_number');
            $table->string('postcode');
            $table->string('city');

            $table->integer('titular_id')->unsigned();
            $table->foreign('titular_id')->references('id')->on('titulars');

            $table->integer('year');
            $table->integer('number');

            $table->string('identifier')->nullable()->default(null);

            $table->integer('archive_id')
              ->unsigned()
              ->nullable()
              ->default(null);
            $table->foreign('archive_id')->references('id')->on('archives');

            $table->string('archive_location')->nullable()->default(null);


            $table->boolean('finished')->nullable()->default(false);

            $table->integer('last_current_stage_id')
              ->unsigned()
              ->nullable()
              ->default(null);

            $table->integer('license_status_id')
              ->unsigned()
              ->nullable()
              ->default(null);
            $table->foreign('license_status_id')->references('id')->on('license_statuses');
            
            $table->enum('visit_status', ['Solicitud puesta en marcha', 'Visita', 'Completado'])->nullable()->default(null);

            $table->string('closet')->nullable();
            $table->string('volume_year')->nullable();
            $table->boolean('on_query')->default(false);
            $table->string('commerce_name')->default(null);
            $table->date('visit_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('licenses');
    }
}
