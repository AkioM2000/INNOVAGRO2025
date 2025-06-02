<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Administrator role with full access'
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Manager role with limited administrative access'
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Regular user role'
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                [
                    'display_name' => $role['display_name'],
                    'description' => $role['description']
                ]
            );
        }
    }
}
