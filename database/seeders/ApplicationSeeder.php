<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\Jobs;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $jobs = Jobs::all();
        
        foreach ($users as $user) {
            foreach ($jobs->random(2) as $job) {
                Application::factory()->create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                ]);
            }
        }
    }
}