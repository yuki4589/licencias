<?php

use Illuminate\Database\Seeder;

class ObjectionNotificationTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\ObjectionNotification::class, 2)->create();
    }
}
