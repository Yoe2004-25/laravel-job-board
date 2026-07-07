<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Jobs;
use App\Models\Companies;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_jobs()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        Jobs::factory()->count(3)->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);

        $this->assertCount(3, $user->jobs);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->jobs);
    }

    public function test_user_has_applications()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);
        $job = Jobs::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
        Application::factory()->count(2)->create([
            'user_id' => $user->id,
            'job_id' => $job->id,
        ]);

        $this->assertCount(2, $user->applications);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->applications);
    }

    public function test_user_has_company()
    {
        $user = User::factory()->create();
        $company = Companies::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Companies::class, $user->company);
        $this->assertEquals($company->id, $user->company->id);
    }

    public function test_user_has_hidden_password()
    {
        $user = User::factory()->create();
        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }
}