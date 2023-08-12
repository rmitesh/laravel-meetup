<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->text(),
            'status' => fake()->boolean(),
            'priority' => rand(0, 4),
            'due_at' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'created_by' => User::all('id')->random()->id,
        ];
    }
}
