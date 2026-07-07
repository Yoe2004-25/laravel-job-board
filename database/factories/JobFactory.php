<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'salary' => $this->faker->numberBetween(30000, 150000),
            'location' => $this->faker->city() . ', ' . $this->faker->state(),
            'company_id' => Companies::factory(),
            'user_id' => User::factory(),
        ];
    }
}