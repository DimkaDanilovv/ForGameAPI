<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(1)
            ->create()
            ->each(
                function($user) {
                    $user->assignRole('admin');
                }
            );
        User::factory()->count(1)
            ->create()
            ->each(
                function($user) {
                    $user->assignRole('moderator');
                }
            );
        User::factory()->count(1)
            ->create()
            ->each(
                function($user) {
                    $user->assignRole('user');
                }
            );


            $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user1234@example.com',
            'password' => 'user1234'
            
        ]);

        $user->assignRole("user");

        $user = User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator1234@example.com',
            'password' => 'moderator1234'
            
        ]);

        $user->assignRole("moderator");

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin1234@example.com',
            'password' => 'admin1234'
            
        ]);

        $user->assignRole("admin");

    }
}
