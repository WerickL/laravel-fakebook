<?php

namespace Database\Factories;

use Api\Post\Model\Post;
use Api\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;
    
    public function definition()
    {
        $user = User::factory()->create();
        return [
            "user_id" => $user->id,
            "description" => fake("pt_BR")->text()
        ];
    }
}