<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Jobs;
use App\Models\User;
use App\Models\Companies;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_belongs_to_company()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        $job = Jobs::factory()->create([
            'company_id' => $company->id,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Companies::class, $job->company);
        $this->assertEquals($company->id, $job->company->id);
    }

    public function test_job_belongs_to_user()
    {
        $user = User::factory()->create();
        $job = Jobs::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $job->user);
        $this->assertEquals($user->id, $job->user->id);
    }

    public function test_job_has_applications()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        $job = Jobs::factory()->create([
            'company_id' => $company->id,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $job->applications);
    }

    public function test_job_scope_filter()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        
        $job1 = Jobs::factory()->create([
            'name' => 'Laravel Developer',
            'location' => 'New York',
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
        
        $job2 = Jobs::factory()->create([
            'name' => 'React Developer',
            'location' => 'Boston',
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);

        $filteredJobs = Jobs::filter(['search' => 'Laravel'])->get();
        
        $this->assertCount(1, $filteredJobs);
        $this->assertEquals('Laravel Developer', $filteredJobs->first()->name);
    }
}