<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'title' => 'Admin',
                'permissions' => Role::getPermissions(),
                'description' => 'Admin roles',
            ],
            [
                'title' => 'Content admin',
                'permissions' => Role::getPermissions(),
                'description' => 'Role for non-admin admin',
            ],
            [
                'title' => 'organisations',
                'permissions' => Role::getPermissions(),
                'description' => 'Saas org roles',
            ],
        ];

        collect($roles)->each(function ($item) {
            Role::create($item);
        });
    }
}
