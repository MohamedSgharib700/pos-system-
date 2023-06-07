<?php

namespace Database\Factories;

use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'is_active' => true,
            'password' => bcrypt('password'),
            'blocked_key' => NULL,
            'phone' => $this->faker->phoneNumber(),
            'identification_number' => $this->faker->unique()->numberBetween(1111111111, 9999999999),
            'user_type' => $this->faker->randomElement($array = array(Manager::FINANCE_MANAGER, Manager::BRANCH_MANAGER)),
            'birthdate' => $this->faker->date('Y-m-d'),
            'remember_token' => Str::random(10),
            'company_id' => Company::newFactory()->create()->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
