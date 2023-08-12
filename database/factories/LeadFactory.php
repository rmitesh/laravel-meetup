<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all('id')->random()->id,
            'lead_number' => 'PROP' . fake()->randomNumber(5, true),
            'full_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone_number' => fake()->e164PhoneNumber(),
            'property_type' => rand(0, 9),
            'location' => fake()->streetAddress(),
            'budget' => fake()->randomFloat(2, 100, 900),
            'bedrooms' => fake()->numberBetween(1, 5),
            'bathrooms' => fake()->numberBetween(1, 5),
            'additional_requirements' => fake()->text(),
        ];
    }
}
