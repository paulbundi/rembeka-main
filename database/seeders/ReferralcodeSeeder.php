<?php

namespace Database\Seeders;

use App\Models\Referralcode;
use Illuminate\Database\Seeder;

class ReferralcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referralcode::factory(30)->create();
    }
}
