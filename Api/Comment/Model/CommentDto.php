<?php
 namespace Api\Comment\Model;
    use Api\User\Model\User;

    class CommentDto
    {
        public function __construct(
            public string $content,
            public ?string $postId,
            public User $user)
        {
        }
        
        public function toArray(){
            return [
                "content" => $this->content
            ];
        }
    }