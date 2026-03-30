<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'account_type' => User::TYPE_ADMIN,
            'organization_id' => null,
            'phone' => '0713240494',
            'password'=>bcrypt('admin')
        ]);

        $user->roles()->attach(Role::first()->id);

        User::factory(20)->hasAddresses(4)->create();
    }
}
