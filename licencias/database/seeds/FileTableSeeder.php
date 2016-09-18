<?php

use Illuminate\Database\Seeder;

class FileTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\File::class, 10)->create();
    }
}
