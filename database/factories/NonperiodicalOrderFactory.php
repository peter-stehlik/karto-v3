<?php

namespace Database\Factories;

use App\Models\NonperiodicalOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class NonperiodicalOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NonperiodicalOrder::class;

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
