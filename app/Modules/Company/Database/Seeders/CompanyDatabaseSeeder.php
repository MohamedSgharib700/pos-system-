<?php

namespace App\Modules\Company\Database\Seeders;

use App\Modules\Company\Database\factories\CompanyFactory;
use App\Modules\Company\Entities\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CompanyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Company::newFactory()
            ->count(5)
            ->create();
    }
}
