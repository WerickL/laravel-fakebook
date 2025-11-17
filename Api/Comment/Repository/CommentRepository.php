<?php
namespace Api\Comment\Repository;

use Api\Comment\Model\Comment;
use Api\Comment\Model\CommentDto;
use Api\User\Model\User;
use Exception;

class CommentRepository {
    public function create(CommentDto $commentDto): Comment| Exception {
        try {
            $comment = new \Api\Comment\Model\Comment();
            $comment->content = $commentDto->content;
            $comment->post_id = $commentDto->postId;
            $comment->user_id = $commentDto->user->id;
            $comment->save();
            return $comment;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function find($id): Comment {
        return Comment::where("id", (int) $id)->first();
    }
    public function patch(Comment $comment, CommentDto $data): Comment {
        $comment = $comment->fill($data->toArray());
        $comment->save();
        
        return $comment;
    }
    public function delete(Comment $comment): bool {
        return $comment->delete();
    }
    public function fetchCommentsByPostId(int $postId){
        return Comment::where("post_id", $postId)->get();
    }
    public function fetchComments(User $user){
        return $user->comments()->get();
    }
}