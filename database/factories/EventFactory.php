<?php

namespace Database\Factories;

use App\Models\Authorization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
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
            'title'           => fake()->text,
            'start_date'      => now()->subDays(3),
            'end_date'        => function(array $attributes) {
                return (clone $attributes['start_date'])->addWeek();
            },
            'organization_id' => Organization::factory(),
        ];
    }
}
