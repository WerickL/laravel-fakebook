<?php
namespace Database\Factories;

use Api\Comment\Model\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;
    public function definition()
    {
        return [
            'post_id' => \Api\Post\Model\Post::factory(),
            'user_id' => \Api\User\Model\User::factory(),
            'content' => fake("pt_BR")->paragraph(),
            'parent_comment_id' => null,
        ];
    }
}