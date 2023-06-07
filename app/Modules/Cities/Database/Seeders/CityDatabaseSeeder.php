<?php

namespace App\Modules\Cities\Database\Seeders;

use App\Modules\Cities\Entities\City;
use Illuminate\Database\Seeder;

class CityDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::factory()->times(5)->create();
    }
}
