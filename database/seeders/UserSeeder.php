<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'phone' => '0123456789',
            'role' => 0,
            'status' => 0,
            'password' => bcrypt('12345678'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'phone' => '0123456788',
            'role' => 1,
            'status' => 0,
            'password' => bcrypt('12345678'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Technician',
            'email' => 'tech@mail.com',
            'phone' => '0123456787',
            'role' => 2,
            'status' => 0,
            'password' => bcrypt('12345678'),
        ]);
    }
}
