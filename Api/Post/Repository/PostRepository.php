<?php
namespace Api\Post\Repository;
use Api\Post\Model\Post;
use Api\Post\Model\PostDto;
use Api\Post\Repository\IPostRepository;

class PostRepository implements IPostRepository{
    public function create(PostDto $postDto): Post
    {
        try {
            $post = $postDto->user->posts()->create([
                "description" => $postDto->description,
                "user_id" => $postDto->user->id
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        return $post;
    }
}