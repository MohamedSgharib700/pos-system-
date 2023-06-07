<?php

namespace App\Modules\BanksAccounts\Database\Seeders;

use App\Modules\BanksAccounts\Entities\BanksAccount;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BanksAccountsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        BanksAccount::factory()->count(5)->create();
    }
}
