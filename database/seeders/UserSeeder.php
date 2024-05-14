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
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => 'example'
        // ]);
        User::factory()->count(1)
            ->create(['password' => 'admin1234'])
            ->each(
                function($user) {
                    $user->assignRole('admin');
                }
            );
        User::factory()->count(2)
            ->create()
            ->each(
                function($user) {
                    $user->assignRole('moderator');
                }
            );
        User::factory()->count(3)
            ->create()
            ->each(
                function($user) {
                    $user->assignRole('user');
                }
            );
    }
}
