<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use App\Models\Jobs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'cv' => 'cvs/' . $this->faker->uuid() . '.pdf',
            'status' => $this->faker->boolean(50),
            'user_id' => User::factory(),
            'job_id' => Jobs::factory(),
        ];
    }
}