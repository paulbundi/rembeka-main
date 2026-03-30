<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ProviderTableSeeder::class);

        // must run before
        $this->call(CategoryTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(LocationTableSeeder::class);

        // have dependency
        // $this->call(MediaTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProviderPricingTableSeeder::class);
        $this->call(OrderTableSeeder::class);
    }
}
