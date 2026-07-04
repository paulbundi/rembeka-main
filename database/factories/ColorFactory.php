<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ColorFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->colorName,
            'slug' => $this->faker->slug,
            'hex_code' => $this->faker->hexColor,
        ];
    }
}