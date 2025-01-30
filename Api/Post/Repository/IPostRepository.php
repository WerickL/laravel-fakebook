<?php
namespace Api\Post\Repository;

use Api\Post\Model\Post;
use Api\Post\Model\PostDto;

interface IPostRepository{
    public function create(PostDto $postDto): Post;
    public function publish(Post $entity): Post;
    public function find(string $id): Post;
    public function patch(Post $model, PostDto $data): Post;
}