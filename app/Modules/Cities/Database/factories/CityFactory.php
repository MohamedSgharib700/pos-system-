<?php
namespace App\Modules\Cities\Database\factories;

use App\Modules\Areas\Entities\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Cities\Entities\City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'name' => ['en' => $this->faker->text(10), 'ar' => $this->faker->text(10)],
            'area_id' => Area::factory()->create()->id,
        ];
    }
}
