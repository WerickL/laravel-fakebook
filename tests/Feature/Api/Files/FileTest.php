<?php

namespace Tests\Feature\Api\File;

use Api\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        Storage::fake();
        $file = UploadedFile::fake()->image('post.png');

        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post('/api/file', [
            "name" => "teste_arquivo.png",
            "content_type" => $file->extension(),
            "content" => $file
        ]);

        $response->assertStatus(201);
        $responseData = $response->json();
        $uuid = $responseData['uuid'];
        Storage::disk()->assertExists("files/{$uuid}");
    }
    public function test_not_create_using_invalid_params():void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post('/api/file');
        $response->assertStatus(422);
    }
}
