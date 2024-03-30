<?php

use Illuminate\Http\Response;

it('stores rider location history successfully', function () {
    $payload = [
        'rider_id' => 1,
        'service_name' => 'Test Service',
        'latitude' => '23.806206',
        'longitude' => '90.359483',
        'capture_time' => now()->toDateTimeString(),
    ];

    $response = $this->postJson('/api/rider/location-history', $payload);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            'message' => 'Rider location history stored successfully',
            'status' => 'success',
        ])
        ->assertJsonStructure([
            'data' => [
                'rider_id', 'service_name', 'latitude', 'longitude', 'capture_time',
            ],
        ]);

    $this->assertDatabaseHas('rider_location_histories', $payload);
});

$validationTests = [
    'rider_id' => null,
    'service_name' => '',
    'latitude' => 'invalid',
    'longitude' => 'invalid',
    'capture_time' => 'not a date',
];

foreach ($validationTests as $field => $value) {
    it('fails due to invalid ' . $field, function () use ($field, $value) {
        $payload = [
            'rider_id' => 1,
            'service_name' => 'Test Service',
            'latitude' => '23.806206',
            'longitude' => '90.359483',
            'capture_time' => now()->toDateTimeString(),
        ];

        $payload[$field] = $value;

        $response = $this->postJson('/api/rider/location-history', $payload);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonValidationErrors([$field]);
    });
}

it('handles exceptions', function () {
    $this->mock(App\Http\Controllers\Api\RiderLocationHistoryController::class, function ($mock) {
        $mock->shouldReceive('store')->andThrow(new Exception('Test exception'));
    });

    $payload = [
        'rider_id' => 1,
        'service_name' => 'Test Service',
        'latitude' => '23.806206',
        'longitude' => '90.359483',
        'capture_time' => now()->toDateTimeString(),
    ];

    $response = $this->postJson('/api/rider/location-history', $payload);

    $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
        ->assertJson([
            'message' => 'Test exception',
        ]);
});
