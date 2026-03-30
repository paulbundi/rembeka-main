<?php

namespace Database\Seeders;

use App\Models\ProviderPricing;
use Illuminate\Database\Seeder;

class ProviderPricingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProviderPricing::factory()->count(20)->create();
    }
}
