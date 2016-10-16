<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_limits', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('weight');
            $table->integer('days');
            #JGT Se agregan los campos de codigo y nombre
            $table->string('name');
            $table->string('code');

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
        Schema::drop('time_limits');
    }
}
