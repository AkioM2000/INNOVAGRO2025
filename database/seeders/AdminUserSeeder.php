<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User default
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Default password is 'password'
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // User Mahendra
        $mahendra = User::updateOrCreate(
            ['email' => 'mahendra@admin.com'],
            [
                'name' => 'Mahendra',
                'password' => Hash::make('password123'), // Password: password123
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create or get regular user role
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['display_name' => 'User', 'description' => 'Regular User']
        );

        // Create or get admin role
        $adminRole = Role::where('name', 'admin')->first();
        
        // Assign admin roles
        if ($adminRole) {
            if (!$admin->hasRole('admin')) {
                $admin->roles()->attach($adminRole);
            }
            if (!$mahendra->hasRole('admin')) {
                $mahendra->roles()->attach($adminRole);
            }
        }

        // Create regular user Akio
        $akio = User::updateOrCreate(
            ['email' => 'akio@user.com'],
            [
                'name' => 'Akio',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Assign user role to Akio
        if (!$akio->hasRole('user')) {
            $akio->roles()->attach($userRole->id);
        }
    }
}
