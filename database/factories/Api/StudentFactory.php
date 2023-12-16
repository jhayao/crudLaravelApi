<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "student_name" => $this->faker->name(),
            "student_email" => $this->faker->email(),
            "student_phone" => $this->faker->phoneNumber(),
            "student_address" => $this->faker->address(),  
            "student_image" => $this->faker->imageUrl(),
        ];
    }
}
