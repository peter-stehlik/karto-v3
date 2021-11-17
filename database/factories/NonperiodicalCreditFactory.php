<?php

namespace Database\Factories;

use App\Models\NonperiodicalCredit;
use Illuminate\Database\Eloquent\Factories\Factory;

class NonperiodicalCreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NonperiodicalCredit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_id' => $this->faker->numberBetween(1, 500),
            'nonperiodical_publication_id' => $this->faker->numberBetween(1, 3),
            'credit' => $this->faker->numberBetween(-40, 100),
        ];
    }
}
