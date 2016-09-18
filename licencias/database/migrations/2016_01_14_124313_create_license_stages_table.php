<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_stages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->boolean('date');
            $table->boolean('date_required')->default(false);
            $table->boolean('person');
            $table->boolean('person_required')->default(false);
            $table->boolean('number');
            $table->boolean('number_required')->default(false);
            $table->boolean('file');
            $table->boolean('file_required')->default(false);
            $table->boolean('objection');
            $table->boolean('objection_required')->default(false);

            $table->boolean('optional')->default(false);

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
        Schema::drop('license_stages');
    }
}
