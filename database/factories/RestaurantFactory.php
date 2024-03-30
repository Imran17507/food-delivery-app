<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mirpur10Latitude = 23.806913;
        $mirpur10Longitude = 90.368650;

        return [
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
        ];
    }
}
