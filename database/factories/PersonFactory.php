<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 26),
            'title' => $this->faker->title,
            'name1' => $this->faker->name,
            'address1' => $this->faker->streetAddress,
            'address2' => '',
            'organization' => $this->faker->company,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'email' => $this->faker->unique()->safeEmail,
            'note' => '',
        ];
    }
}
