<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitularityChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titularity_changes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('license_id')->unsigned();
            $table->foreign('license_id')->references('id')->on('licenses');

            $table->integer('titular_id')->unsigned();
            $table->foreign('titular_id')->references('id')->on('titulars');

            $table->string('expedient_number');
            $table->string('register_number');
            $table->date('register_date');
            $table->boolean('finished')->nullable()->default(false);
            $table->date('finished_date')->nullable()->default(null);
            $table->enum('status', ['Solicitado', 'Concedido', 'Desistido'])->nullable()->default('Solicitado');

            $table->integer('file_id')->unsigned()->nullable()->default(null);
            $table->foreign('file_id')->references('id')->on('files');

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
        Schema::drop('titularity_changes');
    }
}
