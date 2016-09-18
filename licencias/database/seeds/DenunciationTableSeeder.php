<?php

use Illuminate\Database\Seeder;

class DenunciationTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Denunciation::class, 2)->create();
    }
}
