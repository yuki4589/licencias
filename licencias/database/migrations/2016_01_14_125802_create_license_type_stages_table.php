<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseTypeStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_type_stages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('license_type_id')->unsigned();
            $table->foreign('license_type_id')
              ->references('id')
              ->on('license_types');

            $table->integer('license_stage_id')->unsigned();
            $table->foreign('license_stage_id')
              ->references('id')
              ->on('license_stages');

            $table->integer('weight');

            $table->integer('previous')->unsigned()->nullable();
            $table->foreign('previous')->references('id')->on('license_stages');

            $table->integer('next')->unsigned()->nullable();
            $table->foreign('next')->references('id')->on('license_stages');

            $table->boolean('license_generate');

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
        Schema::drop('license_type_stages');
    }
}
