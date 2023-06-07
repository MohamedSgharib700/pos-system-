<?php
namespace App\Modules\Areas\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Areas\Entities\Area::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ['en' => $this->faker->text(10), 'ar' => $this->faker->text(10)]
        ];
    }
}

