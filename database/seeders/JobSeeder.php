<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Companies;
use App\Models\Jobs;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $companies = Companies::all();
        
        foreach ($companies as $company) {
            Jobs::factory(3)->create([
                'company_id' => $company->id,
                'user_id' => $company->user_id,
            ]);
        }
    }
}