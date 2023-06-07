<?php

namespace App\Modules\BanksAccounts\Database\Factories;

use App\Modules\Banks\Entities\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class BanksAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\BanksAccounts\Entities\BanksAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $random_bank = Bank::all();
        $bank_id = count($random_bank) ? $random_bank->random()->id : Bank::factory()->create()->id;
        return [
            'model_type' => 'Bank',
            'model_id' => 1,
            'bank_id' => $bank_id,
            'iban' => $this->faker->iban(),
        ];
    }
}
