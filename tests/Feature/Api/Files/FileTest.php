<?php

namespace Tests\Feature\Api\File;

use Api\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_api_be_found(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->get('/api/file');

        $response->assertStatus(200);
    }
    public function test_create_file_using_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post('/api/file');

        $response->assertStatus(201);
    }
}
