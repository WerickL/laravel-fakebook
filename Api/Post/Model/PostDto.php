<?php
namespace Api\Post\Model;

use Api\User\Model\User;

class PostDto
{
    public function __construct(
        public string $description,
        public User $user)
    {
    }
    
    public function toArray(){
        return [
            "description" => $this->description
        ];
    }
}