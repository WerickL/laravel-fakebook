<?php

namespace Tests\Feature\Api\Posts;

use Api\Post\Model\Post;
use Api\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_post_factory(): void {
        $post = Post::factory()->create();
        $this->assertModelExists($post);
    }
    public function test_create_post_using_api(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet"
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
        ]);
    }
    public function test_create_post_using_api_without_authentication(): void
    {
        $response = $this->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet"
        ]);
        
        $response->assertStatus(403);
    }
}
