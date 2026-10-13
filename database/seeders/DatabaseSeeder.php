<?php

namespace Database\Seeders;

use App\Models\User;
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
       $developers = \App\Models\Developer::factory()->count(4)->create();

        \App\Models\Game::factory()
            ->count(31)
            ->recycle($developers)
            ->create();
    }
}
