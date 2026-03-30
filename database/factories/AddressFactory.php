<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->address,
            'lat'=> $this->faker->latitude,
            'long'=> $this->faker->longitude,
            'appartment'=> $this->faker->name,
            'floor'=> rand(1, 4),
            'room'=> rand(1, 20),
        ];
    }
}
