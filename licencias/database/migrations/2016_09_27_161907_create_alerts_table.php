<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('date');
            $table->string('description');
            $table->integer('license_id')
                ->unsigned()
                ->nullable()
                ->default(null);
            $table->foreign('license_id')->references('id')->on('licenses');
            $table->integer('type_alert_id')
                ->unsigned()
                ->nullable()
                ->default(null);
            $table->foreign('type_alert_id')->references('id')->on('type_alerts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alerts');
    }
}
