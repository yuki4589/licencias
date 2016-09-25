<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            // Administrador
            $now = date('Y-m-d H:i:s');
            \DB::table('users')->insert([
                'name' => 'Administrador',
                'email' => 'administrador@notecity.es',
                'password' => bcrypt('secret'),
                'user_type_id' => 1,
                'remember_token' => str_random(10),
                'created_at' => $now
            ]);

            // Usuario Común
            \DB::table('users')->insert([
                'name' => 'Usuario Comun',
                'email' => 'pruebas@notecity.es',
                'password' => bcrypt('secret'),
                'user_type_id' => 2,
                'remember_token' => str_random(10),
                'created_at' => $now
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
