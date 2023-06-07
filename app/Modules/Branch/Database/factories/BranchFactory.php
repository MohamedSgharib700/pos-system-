<?php
namespace App\Modules\Branch\Database\factories;

use App\Models\Manager;
use App\Modules\Cities\Entities\City;
use App\Modules\Company\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Branch\Entities\Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'company_id'=> Company::newFactory()->create()->id,
            'manager_id'=> Manager::newFactory()->create()->id,
            'city_id'=> City::newFactory()->create()->id,
        ];
    }
}

