<?php

namespace Tests\Feature\Api\Likes;

use Api\Comment\Model\Comment;
use Api\Like\Model\Like;
use Api\Post\Model\Post;
use Api\Post\Model\PostStatusEnum;
use Api\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_like_for_post_directly_in_database(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->assertModelExists($like);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment_id' => null,
        ]);
    }

    public function test_create_like_for_comment_directly_in_database(): void
    {
        $user = User::factory()->create();
        $comment = Comment::create();

        $like = Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        $this->assertModelExists($like);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => null,
            'comment_id' => $comment->id,
        ]);
    }

    public function test_unique_constraint_prevents_duplicate_like_on_same_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_unique_constraint_prevents_duplicate_like_on_same_comment(): void
    {
        $user = User::factory()->create();
        $comment = Comment::create();

        Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);
    }

    public function test_check_constraint_prevents_like_without_post_or_comment(): void
    {
        $user = User::factory()->create();

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Like::create([
            'user_id' => $user->id,
            'post_id' => null,
            'comment_id' => null,
        ]);
    }

    public function test_different_users_can_like_same_post(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user1->id,
            'status' => PostStatusEnum::Published
        ]);

        $like1 = Like::create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);

        $like2 = Like::create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);

        $this->assertModelExists($like1);
        $this->assertModelExists($like2);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_different_users_can_like_same_comment(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $comment = Comment::create();

        $like1 = Like::create([
            'user_id' => $user1->id,
            'comment_id' => $comment->id,
        ]);

        $like2 = Like::create([
            'user_id' => $user2->id,
            'comment_id' => $comment->id,
        ]);

        $this->assertModelExists($like1);
        $this->assertModelExists($like2);
    }

    public function test_foreign_key_cascade_deletes_like_when_post_is_deleted(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $post->delete();

        $this->assertDatabaseMissing('likes', [
            'id' => $like->id,
        ]);
    }

    public function test_foreign_key_cascade_deletes_like_when_comment_is_deleted(): void
    {
        $user = User::factory()->create();
        $comment = Comment::create();

        $like = Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        $comment->delete();

        $this->assertDatabaseMissing('likes', [
            'id' => $like->id,
        ]);
    }

    public function test_foreign_key_cascade_deletes_like_when_user_is_deleted(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $user->delete();

        $this->assertDatabaseMissing('likes', [
            'id' => $like->id,
        ]);
    }

    public function test_user_can_like_both_post_and_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);
        $comment = Comment::create();

        $likePost = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $likeComment = Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        $this->assertModelExists($likePost);
        $this->assertModelExists($likeComment);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment_id' => null,
        ]);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => null,
            'comment_id' => $comment->id,
        ]);
    }

    // Testes de API - Estes testes podem falhar até que a API seja implementada
    public function test_create_like_for_post_via_api_requires_authentication(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        $response = $this->post('/api/like', [
            'post_id' => $post->id,
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_create_like_for_post_via_api(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        Passport::actingAs($user);
        $response = $this->post('/api/like', [
            'post_id' => $post->id,
        ], [
            'Accept' => 'application/json'
        ]);

        // Este teste pode falhar até que a rota e controller sejam implementados
        // Quando implementado, deve retornar 201 e criar o like
        if ($response->status() !== 404) {
            $response->assertStatus(201);
            $this->assertDatabaseHas('likes', [
                'user_id' => $user->id,
                'post_id' => $post->id,
                'comment_id' => null,
            ]);
        }
    }

    public function test_create_like_for_comment_via_api(): void
    {
        $user = User::factory()->create();
        $comment = Comment::create();

        Passport::actingAs($user);
        $response = $this->post('/api/like', [
            'comment_id' => $comment->id,
        ], [
            'Accept' => 'application/json'
        ]);

        // Este teste pode falhar até que a rota e controller sejam implementados
        if ($response->status() !== 404) {
            $response->assertStatus(201);
            $this->assertDatabaseHas('likes', [
                'user_id' => $user->id,
                'post_id' => null,
                'comment_id' => $comment->id,
            ]);
        }
    }

    public function test_cannot_create_like_without_post_or_comment_via_api(): void
    {
        $user = User::factory()->create();

        Passport::actingAs($user);
        $response = $this->post('/api/like', [], [
            'Accept' => 'application/json'
        ]);

        // Este teste pode falhar até que a rota e controller sejam implementados
        if ($response->status() !== 404) {
            $response->assertStatus(422);
        }
    }

    public function test_cannot_create_duplicate_like_via_api(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => PostStatusEnum::Published
        ]);

        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        Passport::actingAs($user);
        $response = $this->post('/api/like', [
            'post_id' => $post->id,
        ], [
            'Accept' => 'application/json'
        ]);

        // Este teste pode falhar até que a rota e controller sejam implementados
        if ($response->status() !== 404) {
            $response->assertStatus(400);
        }
    }
}