<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(LicenseTypeTableSeeder::class);
        $this->call(FileTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(StreetTableSeeder::class);
        $this->call(ArchiveTableSeeder::class);
        $this->call(TitularTableSeeder::class);
        $this->call(LicenseStatusTableSeeder::class);
        $this->call(LicenseTableSeeder::class);
        $this->call(UserTypeTableSeeder::class);
        $this->call(PersonPositionTableSeeder::class);
        $this->call(PersonTableSeeder::class);
        $this->call(LoanTableSeeder::class);
        $this->call(DenunciationTableSeeder::class);
        //$this->call(TitularityChangeTableSeeder::class);
        //$this->call(LicenseStatusChangeTableSeeder::class);
        $this->call(TimeLimitTableSeeder::class);
        $this->call(LicenseStageTableSeeder::class);
        //$this->call(ObjectionTableSeeder::class);
        //$this->call(ObjectionNotificationTableSeeder::class);
        $this->call(LicenseTypeStageTableSeeder::class);
        //$this->call(LicenseCurrentStageTableSeeder::class);

        Model::reguard();
    }
}
