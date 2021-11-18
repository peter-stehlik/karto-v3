<?php

namespace Database\Factories;

use App\Models\PeriodicalCredit;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodicalCreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PeriodicalCredit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_id' => $this->faker->numberBetween(1, 500),
            'periodical_publication_id' => $this->faker->numberBetween(1, 4),
            'credit' => $this->faker->numberBetween(-40, 100),
        ];
    }
}
