<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => Str::slug($this->faker->name),
            'name' => $this->faker->realText(rand(10, 20)),
            'sku'  =>$this->faker->name,
            'description'  =>$this->faker->sentence,
            'keywords'  =>$this->faker->sentence,
            'seo_title'  =>$this->faker->sentence,
            'seo_description'  =>$this->faker->sentence,
            'menu_id' => Menu::inRandomOrder()->first()->id,
            'type' => rand(1, 2),
        ];
    }
}
