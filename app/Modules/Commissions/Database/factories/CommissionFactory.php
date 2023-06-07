<?php
namespace App\Modules\Commissions\Database\factories;

use App\Modules\Company\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Company\Database\factories\CompanyFactory;

class CommissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Commissions\Entities\Commission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value'=> $this->faker->unique()->numberBetween(1, 1000),
            'company_id'=> Company::newFactory()->create()->id
        ];
    }
}

