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

        for ($i = 0; $i < 5; ++$i) {
            $user = User::factory()->create();
            Lead::factory()
                ->count(rand(1, 10))
                ->for($user)
                ->hasAttached(
                    Property::factory()->count(rand(1, 5))
                )
                ->create();
        }
    }
}
