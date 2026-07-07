<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_company()
    {
        $this->actingAs($this->user);

        $companyData = [
            'name' => 'Tech Corp',
            'number_employees' => 100,
            'website_name' => 'techcorp.com',
            'number_phone' => '+1234567890',
            'user_id' => $this->user->id,
        ];

        $response = $this->post(route('companies.store'), $companyData);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name' => 'Tech Corp',
            'website_name' => 'techcorp.com',
        ]);
    }

    public function test_user_can_view_companies()
    {
        Companies::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get(route('companies.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_update_company()
    {
        $this->actingAs($this->user);
        $company = Companies::factory()->create(['user_id' => $this->user->id]);

        $updatedData = [
            'name' => 'Updated Tech Corp',
            'number_employees' => 200,
            'website_name' => 'updatedtechcorp.com',
            'number_phone' => '+1987654321',
            'user_id' => $this->user->id,
        ];

        $response = $this->put(route('companies.update', $company->id), $updatedData);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'Updated Tech Corp',
        ]);
    }

    public function test_user_can_delete_company()
    {
        $this->actingAs($this->user);
        $company = Companies::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('companies.destroy', $company->id));

        $response->assertRedirect(route('companies.index'));
        $this->assertSoftDeleted('companies', ['id' => $company->id]);
    }
}