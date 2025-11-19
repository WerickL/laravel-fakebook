<?php 
namespace Api\Comment\Http\Requests;

use Api\Comment\Model\CommentDto;
use Api\Post\Model\PostDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
{
    public function toDto(){
        return new CommentDto(
            content: $this->input("content"),
            postId: $this->input("post_id"),
            user: $this->user(),
            parentCommentId: $this->input("parent_comment_id")
        );
    }
}