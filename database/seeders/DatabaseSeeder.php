<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('user_role')->insert([
            [
                'title' => 'Super Admin',
                'created_at' => now(),
            ], [
                'title' => 'Admin',
                'created_at' => now(),
            ], [
                'title' => 'Sales Representative',
                'created_at' => now(),
            ], [
                'title' => 'Customer',
                'created_at' => now(),
            ]
        ]);

        // User::factory()->create([
        //     'name' => 'Cyrus Manatad',
        //     'email' => 'cyrusmanatad227@gmail.com',
        //     'role_id' => 1, // Super Admin
        //     'password' => bcrypt('password123'),
        // ]);
    }
}
