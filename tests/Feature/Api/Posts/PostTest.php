<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
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
    public function test_create_post(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post("/post", [
            "description" => "Lorem ipsum dolor sit amet"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
        ]);
    }
}
