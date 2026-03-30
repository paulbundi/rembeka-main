<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::factory()->count(10)->hasProfile(1)->create()->each(function ($provider) {
            $location = Location::inRandomOrder()->limit(3)->get()->pluck('id')->toArray();
            $provider->locations()->syncWithoutDetaching($location);
        });
    }
}
