<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Has full access to all system features',
                'permissions' => [
                    'users.create', 'users.read', 'users.update', 'users.delete',
                    'roles.create', 'roles.read', 'roles.update', 'roles.delete',
                    'system.settings', 'system.logs'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrative access with some restrictions',
                'permissions' => [
                    'users.create', 'users.read', 'users.update',
                    'roles.read',
                    'content.create', 'content.read', 'content.update', 'content.delete'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Can manage content and basic user operations',
                'permissions' => [
                    'users.read',
                    'content.create', 'content.read', 'content.update', 'content.delete'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Standard user with basic permissions',
                'permissions' => [
                    'profile.read', 'profile.update',
                    'content.read'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Guest',
                'slug' => 'guest',
                'description' => 'Limited access for guest users',
                'permissions' => ['content.read'],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        // Create sample users
        $users = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@skills.test',
                'password' => Hash::make('Password@1234'),
                'status' => 'active',
                'roles' => ['super-admin']
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@skills.test',
                'password' => Hash::make('Password@1234'),
                'status' => 'active',
                'roles' => ['admin']
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@skills.test',
                'password' => Hash::make('Password@1234'),
                'status' => 'active',
                'roles' => ['editor']
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@skills.test',
                'password' => Hash::make('Password@1234'),
                'status' => 'active',
                'roles' => ['user']
            ],
            [
                'name' => 'Multi Role User',
                'email' => 'multirole@skills.test',
                'password' => Hash::make('Password@1234'),
                'status' => 'active',
                'roles' => ['admin', 'editor'] // User with multiple roles
            ],
        ];

        foreach ($users as $userData) {
            $roles = $userData['roles'];
            unset($userData['roles']);

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Assign roles to user
            foreach ($roles as $roleSlug) {
                $role = Role::where('slug', $roleSlug)->first();
                if ($role && !$user->hasRole($roleSlug)) {
                    $user->assignRole($role, null, 'Assigned during seeding');
                }
            }
        }

        $this->command->info('Roles and Users seeded successfully!');
    }
}