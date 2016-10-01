<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->timestamps();
        });

        //Reparos
        $now = date('Y-m-d H:i:s');
        \DB::table('type_alerts')->insert([
            'id' => 1,
            'type' => 'Reparos',
            'created_at' => $now
        ]);

        //Creación manual
        $now = date('Y-m-d H:i:s');
        \DB::table('type_alerts')->insert([
            'id' => 2,
            'type' => 'Creación manual',
            'created_at' => $now
        ]);

        //Plazo de espera
        $now = date('Y-m-d H:i:s');
        \DB::table('type_alerts')->insert([
            'id' => 3,
            'type' => 'Plazo de espera',
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
        Schema::drop('type_alerts');
    }
}
