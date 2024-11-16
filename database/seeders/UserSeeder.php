<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@spot2.com',
            'password' => 'Spot2Pass'
        ]);

        User::factory()->create([
            'name' => 'Yohanny J. Lugo',
            'email' => 'yohanny.lugo@spot2.com',
            'password' => 'Spot2Pass'
        ]);
    }
}
