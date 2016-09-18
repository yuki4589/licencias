<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseCurrentStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_current_stages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('license_id')->unsigned();
            $table->foreign('license_id')->references('id')->on('licenses');

            $table->integer('license_stage_id')->unsigned();
            $table->foreign('license_stage_id')
              ->references('id')
              ->on('license_stages');

            $table->integer('weight');

            $table->integer('previous')->unsigned()->nullable();
            $table->foreign('previous')->references('id')->on('license_stages');

            $table->integer('next')->unsigned()->nullable();
            $table->foreign('next')->references('id')->on('license_stages');

            $table->boolean('optional')->default(false);

            $table->boolean('license_generate');

            $table->date('date')->nullable();

            $table->integer('person_id')->unsigned()->nullable();
            $table->foreign('person_id')->references('id')->on('people');

            $table->string('number')->nullable();

            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')->on('files');

            $table->integer('objection_id')->unsigned()->nullable();
            $table->foreign('objection_id')->references('id')->on('objections');

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
        Schema::drop('license_current_stages');
    }
}
