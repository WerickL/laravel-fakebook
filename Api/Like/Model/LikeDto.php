<?php
namespace Api\Like\Model;
class LikeDto {
    public function __construct(
        public ?int $postId,
        public ?int $commentId,
        public int $userId
    )
    {
    }

    public function toArray(){
        return [
            "post_id" => $this->postId,
            "comment_id" => $this->commentId,
            "user_id" => $this->userId
        ];
    }
}