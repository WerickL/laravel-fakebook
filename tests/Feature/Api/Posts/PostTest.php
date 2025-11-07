<?php

namespace Tests\Feature\Api\Posts;

use Api\Post\Model\Post;
use Api\Post\Model\PostStatusEnum;
use Api\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
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
        Passport::actingAs($user);
        $response = $this->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet"
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Draft
        ]);
    }
    public function test_create_post_already_published_using_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post("/api/post?publish=true", [
            "description" => "Lorem ipsum dolor sit amet"
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Published
        ]);
    }
    public function test_create_post_and_publish_using_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet",
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Draft
        ]);
        $postId = $response->json()['id'];
        $responsePatch = $this->patch("/api/post/$postId?publish=true", [
            "description" => "Lorem ipsum dolor sit amet",
        ],[
            "Accept" => "application/json"
        ]);
        $responsePatch->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Published
        ]);
    }
    public function test_create_post_and_patching_using_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet patch",
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet patch',
            "status" => PostStatusEnum::Draft
        ]);


        $postId = $response->json()['id'];
        $responsePatch = $this->patch("/api/post/$postId?publish=true", [
            "description" => "Lorem ipsum dolor sit amet patched",
        ],[
            "Accept" => "application/json"
        ]);
        $responsePatch->assertStatus(200);
        $responsePatch->assertJson([
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet patched',
            "status" => "P"
        ]);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet patched',
            "status" => PostStatusEnum::Published
        ]);
    }
    public function test_create_post_and_patching_using_a_different_user_via_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet patch",
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet patch',
            "status" => PostStatusEnum::Draft
        ]);


        $postId = $response->json()['id'];
        $user = User::factory()->create();
        Passport::actingAs($user);
        $responsePatch = $this->patch("/api/post/$postId?publish=true", [
            "description" => "Lorem ipsum dolor sit amet patched",
        ],[
            "Accept" => "application/json"
        ]);
        $responsePatch->assertStatus(403);
    }
    public function test_get_post_via_api(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->post("/api/post?publish=true", [
            "description" => "Lorem ipsum dolor sit amet",
        ],[
            "Accept" => "application/json"
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Published
        ]);

        $responseGet = $this->get("/api/post", [
            "Accept" => "application/json"
        ]);
        $responseGet->assertStatus(200);
        $responseGet->assertJson([[
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => "P"
        ]]);
    }
    public function test_get_post_filtering_by_owner_via_api(): void
    {
        $user = User::factory()->create();        
        Passport::actingAs($user);
        $response = $this->post("/api/post?publish=true", [
            "description" => "Lorem ipsum dolor sit amet",
        ],[
            "Accept" => "application/json"
        ]);

        $user2 = User::factory()->create();
        Passport::actingAs($user2);
        $response2 = $this->post("/api/post?publish=true", [
            "description" => "Lorem ipsum dolor sit amet",
        ],[
            "Accept" => "application/json"
        ]);
        $response->assertStatus(201);
        $response2->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            "user_id" => $user->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Published
        ]);
        $this->assertDatabaseHas('posts', [
            "user_id" => $user2->id,
            'description' => 'Lorem ipsum dolor sit amet',
            "status" => PostStatusEnum::Published
        ]);
        $responseGet = $this->get("/api/post", [
            "Accept" => "application/json"
        ]);
        $responseGet->assertStatus(200);
        $responseGet->assertJsonMissing([
            "user_id" => $user->id
        ]);
    }
    public function test_get_post_using_api_without_authentication(): void
    {
        $response = $this->get("/api/post",
        [
            "Accept" => "application/json"
        ]);
        
        $response->assertStatus(401);
    }
    public function test_create_post_using_api_without_authentication(): void
    {
        $response = $this->post("/api/post", [
            "description" => "Lorem ipsum dolor sit amet"
        ],
        [
            "Accept" => "application/json"
        ]);
        
        $response->assertStatus(401);
    }
    public function test_list_posts_includes_followed_users_posts(): void
    {
        $user = User::factory()->create();
        $followedUser = User::factory()->create();
        $notFollowedUser = User::factory()->create();

        Passport::actingAs($user);
        $response = $this->post("/api/post?publish=true", [
            "description" => "My published post",
        ], [
            "Accept" => "application/json"
        ]);
        $response->assertStatus(201);

        Passport::actingAs($followedUser);
        $responseFollowed = $this->post("/api/post?publish=true", [
            "description" => "Followed user post",
        ], [
            "Accept" => "application/json"
        ]);
        $responseFollowed->assertStatus(201);

        Passport::actingAs($notFollowedUser);
        $responseNotFollowed = $this->post("/api/post?publish=true", [
            "description" => "Not followed user post",
        ], [
            "Accept" => "application/json"
        ]);
        $responseNotFollowed->assertStatus(201);

        Passport::actingAs($user);
        $followResponse = $this->get("/api/user/follow/{$followedUser->id}", [
            "Accept" => "application/json"
        ]);
        $followResponse->assertStatus(200);

        $listResponse = $this->get("/api/post", [
            "Accept" => "application/json"
        ]);

        $listResponse->assertStatus(200);
        $listResponse->assertJsonFragment([
            "user_id" => $user->id,
            "description" => "My published post",
            "status" => "P"
        ]);
        $listResponse->assertJsonFragment([
            "user_id" => $followedUser->id,
            "description" => "Followed user post",
            "status" => "P"
        ]);
        $listResponse->assertJsonMissing([
            "user_id" => $notFollowedUser->id,
            "description" => "Not followed user post"
        ]);
    }
}
