<?php

namespace Database\Seeders;

use App\Models\PosUser;
use App\Modules\Branch\Entities\Branch;
use App\Modules\Company\Entities\Company;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PosUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        if(!PosUser::count()) {
            PosUser::create([
                'company_id' => Company::newFactory()->create()->id,
                'branch_id' => Branch::newFactory()->create()->id,
                'name' => 'pos user',
                'email' => 'pos_user@rasid.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'phone' => $faker->phoneNumber(),
                'identification_number' => $faker->numberBetween(111111111111, 999999999999),
                'serial_number' => $faker->numberBetween(111111111111, 999999999999),
                'serial_code' => $faker->numberBetween(111111111111, 999999999999),
            ]);
        }
        PosUser::factory()->count(5)->create();
    }
}
