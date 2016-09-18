<?php

use Illuminate\Database\Seeder;

class LoanTableSeeder extends Seeder
{

    public function run()
    {
        factory(CityBoard\Entities\Loan::class, 2)->create();
    }
}
