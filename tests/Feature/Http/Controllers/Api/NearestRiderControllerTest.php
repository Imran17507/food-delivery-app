<?php

use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\RiderLocationHistory;
use Carbon\Carbon;
use Illuminate\Http\Response;

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

    $rider = Rider::factory()->create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email_address' => fake()->unique()->email(),
        'contact_no' => fake()->unique()->phoneNumber(),
        'present_address' => fake()->address(),
        'permanent_address' => fake()->address(),
        'nid_no' => fake()->unique()->numberBetween(1000000000, 9999999999999),
        'passport_no' => fake()->unique()->numberBetween(1000000000, 9999999999999),
        'emergency_contact_persons_name' => fake()->unique()->name(),
        'emergency_contact_persons_contact_no' => fake()->unique()->phoneNumber(),
        'created_by' => 'System'
    ]);

    $lat = $restaurant->latitude;
    $long = $restaurant->longitude;

    $riderLocationHistory = RiderLocationHistory::factory()->create([
        'rider_id' => $rider->id,
        'service_name' => fake()->randomElement(['Pathao', 'HungryNaki', 'UberEats', 'Foodpanda']),
        'latitude' => $lat,
        'longitude' => $long,
        'capture_time' => Carbon::now(),
    ]);

    $response = $this->json('POST', '/api/restaurant/nearest-rider', ['restaurant_id' => $restaurant->id]);

    $response->assertStatus(Response::HTTP_OK)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Nearest rider found',
             ])
             ->assertJsonPath('data.rider_id', $riderLocationHistory->rider_id);
});

it('returns a validation error if restaurant_id is not provided', function () {
    $response = $this->json('POST', '/api/restaurant/nearest-rider', []);

    $response->assertStatus(Response::HTTP_BAD_REQUEST)
             ->assertJson([
                 'status' => 'error',
                 'message' => 'Validation error',
             ]);
});

it('handles exceptions', function () {
    $this->mock(App\Http\Controllers\Api\NearestRiderController::class, function ($mock) {
        $mock->shouldReceive('nearestRider')->andThrow(new Exception('Database error'));
    });

    $payload = [
        'restaurant_id' => 999
    ];

    $response = $this->json('POST', '/api/restaurant/nearest-rider', $payload);

    $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
             ->assertJson([
                 'message' => 'Database error',
             ]);
});
