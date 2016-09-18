<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_statuses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 100);
            $table->boolean('initial')->nullable()->default(null);
            $table->boolean('reopen')->nullable()->default(null);
            $table->boolean('identifier')->nullable()->default(null);
            $table->boolean('success')->nullable()->default(null);
            $table->boolean('reject')->nullable()->default(null);
            

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
        Schema::drop('license_statuses');
    }
}
