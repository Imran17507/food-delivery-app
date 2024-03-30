<?php

use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\RiderLocationHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

uses(RefreshDatabase::class);

it('successfully retrieves the nearest rider for a restaurant in mirpur sector 10', function () {
    $mirpur10Latitude = 23.806913;
    $mirpur10Longitude = 90.368650;

    $restaurant = Restaurant::factory()->create([
        'title' => fake()->company(),
        'email_address' => fake()->unique()->companyEmail(),
        'contact_no' => fake()->unique()->phoneNumber(),
        'address' => fake()->address(),
        "latitude" => fake()->latitude($min = ($mirpur10Latitude - (rand(0,20) / 1000)), $max = ($mirpur10Latitude + (rand(0,20) / 1000))),
        "longitude" => fake()->longitude($min = ($mirpur10Longitude - (rand(0,20) / 1000)), $max = ($mirpur10Longitude + (rand(0,20) / 1000))),
        'owners_name' => fake()->name(),
        'owners_email_address' => fake()->unique()->email(),
        'owners_contact_no' => fake()->unique()->phoneNumber(),
        'owners_present_address' => fake()->address(),
        'created_by' => 'System'
    ]);

    Rider::factory()->count(1)->create();

    $lat = $restaurant->latitude + (rand(-100, 100) / 10000.0);
    $long = $restaurant->longitude + (rand(-100, 100) / 10000.0);

    $riderLocationHistory = RiderLocationHistory::factory()->create([
        'rider_id' => 1,
        'service_name' => fake()->randomElement(['Pathao', 'HungryNaki', 'UberEats', 'Foodpanda']),
        'latitude' => $lat,
        'longitude' => $long,
        'capture_time' => Carbon::now()->subSeconds(rand(0, 300)),
    ]);

    $response = $this->json('POST', '/api/restaurant/nearest-rider', ['restaurant_id' => $restaurant->id]);

    $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Nearest rider found',
             ])
             ->assertJsonPath('data.rider_id', $riderLocationHistory->rider_id);
});
