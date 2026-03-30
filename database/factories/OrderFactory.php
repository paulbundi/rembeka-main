<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_no' => Str::random(8),
            'paid' =>  rand(500, 50000),
            'notes' => $this->faker->sentence,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => rand(1, 8),
        ];
    }
}
