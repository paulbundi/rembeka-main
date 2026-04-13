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
        $adminRole = Role::first()->id;

        $admins = [
            [
                'email' => 'mrembeka@gmail.com',
                'first_name' => 'Julie',
                'last_name' => 'Eluid',
                'account_type' => User::TYPE_ADMIN,
                'organization_id' => null,
                'phone' => '0789311440',
                'password' => bcrypt('Mrembeka@123'),
            ],
            [
                'email' => 'mwanjeriloice@gmail.com',
                'first_name' => 'Millicent',
                'last_name' => 'Wanjeri',
                'account_type' => User::TYPE_ADMIN,
                'organization_id' => null,
                'phone' => '0719834595',
                'password' => bcrypt('Mwanjeri@123'),
            ],
        ];

        foreach ($admins as $adminData) {
            $user = User::factory()->create($adminData);
            $user->roles()->attach($adminRole);
        }

        User::factory(20)->hasAddresses(4)->create();
    }
}
