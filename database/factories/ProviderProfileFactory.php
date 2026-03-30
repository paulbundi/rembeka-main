<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'professional_qualifications' => $this->faker->sentence,
            'works_experience' => $this->faker->sentence,
        ];
    }
}
