<?php

namespace Database\Factories;

use App\Modules\Branch\Entities\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class POsUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $branch = Branch::factory()->create();
        return [
            'branch_id' => $branch->id,
            'company_id' => $branch->company->id,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => $this->faker->phoneNumber(),
            'serial_number' => $this->faker->randomDigitNotNull(),
            'serial_code' => $this->faker->randomDigitNotNull(),
            'identification_number' => $this->faker->randomDigitNotNull(),
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
