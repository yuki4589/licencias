<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        //Administrador
        $now = date('Y-m-d H:i:s');
        \DB::table('user_types')->insert([
            'id' => 1,
            'name' => 'Administrador',
            'created_at' => $now
        ]);

        //Usuario Común
        $now = date('Y-m-d H:i:s');
        \DB::table('user_types')->insert([
            'id' => 2,
            'name' => 'Usuario',
            'created_at' => $now
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_types');
    }
}
