<?php
namespace App\Modules\Permission\Database\factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Modules\Permission\Entities\Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name(),
            'slug'=> $this->faker->unique()->name() .'-'. Str::random(10).'-'. uniqid(),
            'guard_name' => 'admin'
        ];
    }
}

