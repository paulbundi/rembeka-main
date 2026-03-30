<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderPricingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'provider_id' => Provider::inRandomOrder()->first()->id,
            'location_id' => Location::inRandomOrder()->first()->id,
            'amount' => rand(1000, 20000),
        ];
    }
}
