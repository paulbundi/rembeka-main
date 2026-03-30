<?php

namespace Database\Factories;

use App\Models\Referralcode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferralcodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text(30),
            'description' => $this->faker->sentence,
            'referrer' => User::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'acquisition_cost' => 100,
            'status' => Referralcode::STATUS_ACTIVE
        ];
    }
}
