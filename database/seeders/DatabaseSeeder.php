<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Lead;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Main User
        User::factory()->create([
            'name' => 'Mitesh Rathod',
            'email' => 'miteshr32@gmail.com',
        ]);
        
        User::factory()
            ->count(5)
            ->has(
                Lead::factory()
                    ->count(10)
                    ->hasAttached(
                        Property::factory()->count(5)
                    )
            )
            ->create();
    }
}
