<?php
 namespace Api\Comment\Model;
    use Api\User\Model\User;

    class CommentDto
    {
        public function __construct(
            public string $content,
            public ?int $postId,
            public User $user,
            public ?int $parentCommentId = null)
        {
        }
        
        public function toArray(){
            return [
                "content" => $this->content,
                "parent_comment_id" => $this->parentCommentId
            ];
        }
    }