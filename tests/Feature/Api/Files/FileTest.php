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

        $response->assertStatus(422);
    }
    public function test_create_file_using_api(): void
    {
        Storage::fake('public');
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
        Storage::disk("public")->assertExists("files/{$uuid}.png");
    }
    public function test_not_create_using_invalid_params():void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post('/api/file');
        $response->assertStatus(422);
    }
    public function test_not_create_file_in_another_user_post(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('post.png');
        
        // Criar dois usuários diferentes
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // Criar um post para o primeiro usuário
        $post = \Api\Post\Model\Post::factory()->create([
            'user_id' => $user1->id
        ]);
        
        // Tentar criar um arquivo no post do primeiro usuário usando o segundo usuário
        Passport::actingAs($user2);
        $response = $this->post('/api/file', [
            "name" => "teste_arquivo.png",
            "content_type" => $file->extension(),
            "content" => $file,
            "post_id" => $post->id
        ]);

        $response->assertStatus(403);
        Storage::disk()->assertMissing("files/*");
    }
    public function test_upload_and_read_file(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('post.png');
        $fileContent = file_get_contents($file->getPathname());

        $user = User::factory()->create();
        Passport::actingAs($user);
        
        // Upload do arquivo
        $response = $this->post('/api/file', [
            "name" => "teste_arquivo.png",
            "content_type" => $file->extension(),
            "content" => $file
        ]);

        $response->assertStatus(201);
        $responseData = $response->json();
        $uuid = $responseData['uuid'];
        
        // Verificar se o arquivo foi salvo
        if (Storage::disk('public')->exists("files/{$uuid}.png")) {
            Storage::disk('public')->assertExists("files/{$uuid}.png");
        } else {
            $this->fail("Arquivo não encontrado");
        }
        
        // Ler o arquivo
        $readResponse = $this->get("/api/file/{$uuid}",[
            "Accept" => "application/json"
        ]);
        if ($readResponse->status() == 200) {
            $this->assertEquals($fileContent, $readResponse->getContent());
        } else {
            $this->fail($readResponse->getContent());
        }
    }

    public function test_upload_file_to_draft_post(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('post.png');

        $user = User::factory()->create();
        Passport::actingAs($user);
        
        // Criar um post em rascunho
        $post = \Api\Post\Model\Post::factory()->create([
            'user_id' => $user->id,
            'status' => \Api\Post\Model\PostStatusEnum::Draft
        ]);

        // Upload do arquivo vinculado ao post
        $response = $this->post('/api/file', [
            "name" => "teste_arquivo.png",
            "content_type" => $file->extension(),
            "content" => $file,
            "post_id" => $post->id
        ]);

        $response->assertStatus(201);
        $responseData = $response->json();
        
        // Verificar se o arquivo foi vinculado ao post
        $this->assertDatabaseHas('files', [
            'fileable_id' => $post->id,
            'fileable_type' => "Post"
        ]);
    }

    public function test_cannot_upload_file_to_published_post(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('post.png');

        $user = User::factory()->create();
        Passport::actingAs($user);
        
        // Criar um post publicado
        $post = \Api\Post\Model\Post::factory()->create([
            'user_id' => $user->id,
            'status' => \Api\Post\Model\PostStatusEnum::Published
        ]);

        // Tentar fazer upload de arquivo para o post publicado
        $response = $this->post('/api/file', [
            "name" => "teste_arquivo.png",
            "content_type" => $file->extension(),
            "content" => $file,
            "post_id" => $post->id
        ]);

        $response->assertStatus(403);
        Storage::disk()->assertMissing("files/*");
    }

    public function test_list_files_from_post(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Passport::actingAs($user);
        
        // Criar um post em rascunho
        $post = \Api\Post\Model\Post::factory()->create([
            'user_id' => $user->id,
            'status' => \Api\Post\Model\PostStatusEnum::Draft
        ]);

        // Criar 3 arquivos para o post
        for ($i = 1; $i <= 3; $i++) {
            $file = UploadedFile::fake()->image("post{$i}.png");
            $this->post('/api/file', [
                "name" => "teste_arquivo{$i}.png",
                "content_type" => $file->extension(),
                "content" => $file,
                "post_id" => $post->id
            ]);
        }

        // Listar arquivos do post
        $response = $this->get("/api/post/{$post->id}");
        $response->assertStatus(200);
        $files = $response->json()["files"];
        $this->assertCount(3, $files);
    }
}
