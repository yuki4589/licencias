<?php

use Illuminate\Database\Seeder;

class ArchiveTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Archive::class, 2)->create();
    }
}
