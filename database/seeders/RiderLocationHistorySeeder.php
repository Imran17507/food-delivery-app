<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Restaurant;
use App\Models\RiderLocationHistory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RiderLocationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            for ($i = 0; $i < 100; $i++) {
                $lat = $restaurant->latitude + (rand(-100, 100) / 10000.0);
                $long = $restaurant->longitude + (rand(-100, 100) / 10000.0);
                $captureTime = Carbon::now()->subSeconds(rand(0, 300));

                RiderLocationHistory::insert([
                    'rider_id' => rand(1, 100),
                    'service_name' => fake()->randomElement(['Pathao', 'HungryNaki', 'UberEats', 'Foodpanda']),
                    'latitude' => $lat,
                    'longitude' => $long,
                    'capture_time' => $captureTime,
                ]);
            }
        }
    }
}
