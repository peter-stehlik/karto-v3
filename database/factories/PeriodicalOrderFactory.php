<?php

namespace Database\Factories;

use App\Models\PeriodicalOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodicalOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PeriodicalOrder::class;

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
            'count' => $this->faker->numberBetween(1, 10),
            'valid_from' => $this->faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
            'valid_to' => $this->faker->dateTimeBetween($startDate = '-10 years', $endDate = '+1 year'),
            'note' => '',
            'gratis' => 0,
        ];
    }
}
