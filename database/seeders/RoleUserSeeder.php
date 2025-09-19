<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Educator User
        User::create([
            'name' => 'Teacher John',
            'email' => 'educator@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'educator',
            'email_verified_at' => now(),
        ]);

        // Create Student User
        User::create([
            'name' => 'Student Alice',
            'email' => 'student@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        // Create additional test users
        User::factory(10)->create([
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        User::factory(3)->create([
            'role' => 'educator',
            'email_verified_at' => now(),
        ]);
    }
}
