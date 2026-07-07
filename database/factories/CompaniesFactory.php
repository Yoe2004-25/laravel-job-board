<?php

namespace Database\Factories;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Companies>
 */
class CompaniesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->company(),
            'number_employees' => $this->faker->numberBetween(10, 1000),
            'website_name' => $this->faker->domainName(),
            'number_phone' => $this->faker->phoneNumber(),
            'user_id' => User::factory(),
        ];
    }
}