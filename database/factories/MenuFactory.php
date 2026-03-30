<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->sentence(),
            'parent_id' => rand(1, 5),
            'status' => Menu::STATUS_ACTIVE,
            'position' => rand(1, 20),
        ];
    }
}
