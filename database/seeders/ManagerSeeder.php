<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Manager;
use Illuminate\Support\Str;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        if(!Manager::count()) {
            Manager::create([
                'name' => 'Super Manager',
                'is_active' => 1,
                'email' => 'supermanager@rasid.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'phone' => $faker->phoneNumber(),
                'identification_number' => $faker->randomDigitNotNull(),
                'user_type' => $faker->randomElement($array = array(Manager::OWNER, Manager::FINANCE_MANAGER, Manager::BRANCH_MANAGER)),
                'birthdate' => $faker->date('Y-m-d'),
                'remember_token' => Str::random(10),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s')
            ]);
        }

        Manager::factory()->count(5)->create();
    }
}
