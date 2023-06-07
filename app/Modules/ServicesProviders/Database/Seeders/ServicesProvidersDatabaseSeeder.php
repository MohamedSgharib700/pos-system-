<?php

namespace App\Modules\ServicesProviders\Database\Seeders;

use App\Modules\ServicesProviders\Entities\ServicesProvider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ServicesProvidersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        ServicesProvider::factory()->count(5)->create();
    }
}
