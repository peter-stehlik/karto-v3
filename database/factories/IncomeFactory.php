<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_id' => $this->faker->numberBetween(1, 500),
            'user_id' => $this->faker->numberBetween(1, 3),
            'sum' => $this->faker->numberBetween(5, 300),
            'bank_account_id' => $this->faker->numberBetween(1, 5),
            'number' => $this->faker->numberBetween(0, 500),
            'package_number' => '',
            'invoice' => '',
            'accounting_date' => $this->faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
            'confirmed' => 1,
            'note' => '',
            'income_date' => $this->faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
        ];
    }
}
