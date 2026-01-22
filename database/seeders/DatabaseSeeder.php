<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            TeamsSeeder::class,
            TechnologiesSeeder::class,
        ]);

        \App\Models\Partner::create(['name' => 'Microsoft', 'country' => 'USA']);
        \App\Models\Partner::create(['name' => 'Indra', 'country' => 'Spain']);
    
        $this->call([
            ProjectsSeeder::class,
        ]);
    }
}
