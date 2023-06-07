<?php

namespace Database\Seeders;

use App\Modules\Permission\Database\Seeders\PermissionDatabaseSeeder;
use App\Modules\Permission\Database\Seeders\FirstRoleTableSeeder;
use App\Modules\Areas\Database\Seeders\AreaDatabaseSeeder;
use App\Modules\Banks\Database\Seeders\BanksDatabaseSeeder;
use App\Modules\BanksAccounts\Database\Seeders\BanksAccountsDatabaseSeeder;
use App\Modules\Cities\Database\Seeders\CityDatabaseSeeder;
use App\Modules\ServicesProviders\Database\Seeders\ServicesProvidersDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            FirstRoleTableSeeder::class,
            PermissionDatabaseSeeder::class,
            AdminSeeder::class,
            AreaDatabaseSeeder::class,
            CityDatabaseSeeder::class,
            ManagerSeeder::class,
            ServicesProvidersDatabaseSeeder::class,
            BanksDatabaseSeeder::class,
            BanksAccountsDatabaseSeeder::class,
            PosUserSeeder::class,
        ]);
    }
}
