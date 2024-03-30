<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Rider::factory()->count(100)->create();
        Restaurant::factory()->count(50)->create();
    }
}
