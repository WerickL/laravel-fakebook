<?php

namespace Database\Factories;

use Api\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition()
    {
        $user = User::factory()->create();
        return [
            "user_id" => $user->id,
            "description" => fake("pt_BR")->text()
        ];
    }
}