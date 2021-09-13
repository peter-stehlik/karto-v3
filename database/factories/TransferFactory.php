<?php

namespace Database\Factories;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transfer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'income_id' => $this->faker->numberBetween(1, 1000),
            'sum' => $this->faker->numberBetween(5, 50),
            'periodical_publication_id' => $this->faker->numberBetween(0, 4),
            'nonperiodical_publication_id' => $this->faker->numberBetween(0, 3),
            'note' => '',
            'transfer_date' => $this->faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
        ];
    }
}
