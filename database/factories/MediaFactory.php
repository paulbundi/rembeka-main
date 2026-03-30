<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path' => storage_path().$this->faker->image('public/storage/images', 640, 480, null, false),
            'name' => $this->faker->name,
            'mime_type' => 'test',
            'disk' => 'public',
            'extension' => 'png',
            'size' => '234',
            'user_id' => 1,
        ];
    }
}
