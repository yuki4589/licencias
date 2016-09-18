<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\User::class)->create([
          'email' => 'mmanzano@gmail.com',
          'password' => bcrypt('secret'),
        ]);
    }
}