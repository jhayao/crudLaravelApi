<?php

namespace Database\Seeders;

use App\Models\Api\Student;
use App\Models\Api\Event;
use App\Models\Api\Attendance;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        Event::factory(5)->create();
        User::factory(20)->create()->each(function ($user) {
            Student::factory()->create([
                'student_name' => $user->name,
                'student_email' => $user->email,
                'student_phone' => fake()->phoneNumber(),
                'student_address' => fake()->address(),
            ]);
        });
        User::create([
            'name' => 'Test User',
            'email' => 'liernuj25@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 0
        ]);
        Student::create([
            'student_name' => "Test User",
            'student_email' => 'liernuj25@gmail.com',
            'student_phone' => fake()->phoneNumber(),
            'student_address' => fake()->address(),
        ]);

        // Attendance::factory(20)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
