<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "event_name" => $this->faker->word(),
            "event_date" => $this->faker->dateTime(),
            // "event_time" => $this->faker->time(),
            "event_location" => $this->faker->address(),
            "event_description" => $this->faker->text(),
        ];
    }
}
