<?php

namespace App\Modules\Areas\Database\Seeders;

use App\Modules\Areas\Entities\Area;
use Illuminate\Database\Seeder;

class AreaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::factory()->times(5)->create();
    }
}
