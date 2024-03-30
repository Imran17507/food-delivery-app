<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rider>
 */
class RiderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
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
        ];
    }
}
