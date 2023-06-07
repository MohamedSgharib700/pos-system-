<?php
namespace App\Modules\Company\Database\factories;

use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Company\Entities\Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'tax_number' => (String) $this->faker->numberBetween(1111111111, 9999999999),
            'commercial_register' => (String) $this->faker->numberBetween(1111111111, 9999999999),
            'type' => $this->faker->randomElement($array = Company::getTypes()),
        ];
    }
}
