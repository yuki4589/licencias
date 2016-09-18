<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectionNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objection_notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('objection_id')->unsigned();
            $table->foreign('objection_id')->references('id')->on('objections');

            $table->integer('time_limit_id')->unsigned();
            $table->foreign('time_limit_id')
              ->references('id')
              ->on('time_limits');

            $table->date('notification_date');
            $table->date('finish_date');

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
        Schema::drop('objection_notifications');
    }
}
