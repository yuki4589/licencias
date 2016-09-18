<?php

use Illuminate\Database\Seeder;

class UserTypeTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\UserType::class, 2)->create();
    }
}
