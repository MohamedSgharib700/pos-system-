<?php

namespace App\Modules\Banks\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Banks\Entities\Bank::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'en' => $this->faker->name(),
                'ar' => $this->faker->name()
            ]
        ];
    }
}
