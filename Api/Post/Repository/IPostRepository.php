<?php
namespace Api\Post\Repository;

use Api\Post\Model\Post;
use Api\Post\Model\PostDto;
use Api\User\Model\User;
use Illuminate\Database\Eloquent\Collection;

interface IPostRepository{
    public function create(PostDto $postDto): Post;
    public function publish(Post $entity): Post;
    public function find(string $id): Post;
    public function findAll(User $user): Collection;
    public function patch(Post $model, PostDto $data): Post;
}