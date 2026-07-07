<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Application;
use App\Models\User;
use App\Models\Jobs;
use App\Models\Companies;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_belongs_to_user()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        $job = Jobs::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
        $application = Application::factory()->create([
            'user_id' => $user->id,
            'job_id' => $job->id,
        ]);

        $this->assertInstanceOf(User::class, $application->user);
        $this->assertEquals($user->id, $application->user->id);
    }

    public function test_application_belongs_to_job()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        $job = Jobs::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
        $application = Application::factory()->create([
            'user_id' => $user->id,
            'job_id' => $job->id,
        ]);

        $this->assertInstanceOf(Jobs::class, $application->job);
        $this->assertEquals($job->id, $application->job->id);
    }

    public function test_application_status_is_boolean()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        $job = Jobs::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
        $application = Application::factory()->create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => true,
        ]);

        $this->assertIsBool($application->status);
        $this->assertTrue($application->status);
    }
}