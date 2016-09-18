<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseStatusChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_status_changes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('license_id')->unsigned();
            $table->foreign('license_id')->references('id')->on('licenses');

            $table->integer('license_status_id')->unsigned();
            $table->foreign('license_status_id')
              ->references('id')
              ->on('license_statuses');

            $table->string('reason')->nullable()->default(null);
            
            $table->date('change_date');

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
        Schema::drop('license_status_changes');
    }
}
