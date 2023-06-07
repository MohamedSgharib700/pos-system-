<?php

namespace App\Modules\Banks\Database\Seeders;

use App\Modules\Banks\Entities\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BanksDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Bank::factory()->count(5)->create();
    }
}
