<?php

namespace App\Modules\ServicesProviders\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServicesProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\ServicesProviders\Entities\ServicesProvider::class;

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
