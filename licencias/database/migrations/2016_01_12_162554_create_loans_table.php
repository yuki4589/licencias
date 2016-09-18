<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('license_id')->unsigned();
            $table->foreign('license_id')->references('id')->on('licenses');

            $table->integer('person_id')->unsigned();
            $table->foreign('person_id')->references('id')->on('people');

            $table->date('loan_date');
            $table->date('giving_back_date')->nullable();

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
        Schema::drop('loans');
    }
}
