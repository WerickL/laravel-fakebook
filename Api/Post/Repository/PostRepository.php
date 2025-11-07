<?php
namespace Api\Post\Repository;
use Api\Post\Model\Post;
use Api\Post\Model\PostDto;
use Api\Post\Model\PostStatusEnum;
use Api\Post\Repository\IPostRepository;
use Api\User\Model\User;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements IPostRepository{
    public function create(PostDto $postDto): Post
    {
        try {
            $post = $postDto->user->posts()->create([
                "description" => $postDto->description,
                "user_id" => $postDto->user->id,
                "status" => PostStatusEnum::Draft
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        return $post;
    }
    public function publish(Post $entity): Post
    {
        $entity->status = PostStatusEnum::Published;
        $entity->save();
        return $entity;
    }
    public function find($id): Post{
        return Post::where("id", (int) $id)->first();
    }
    /**
     * @return Post[]
     */
    public function findAll(User $user): Collection
    {
        $userIds = $user->following()->pluck('users.id')->push($user->id);

        return Post::whereIn('user_id', $userIds)->get();
    }
    public function patch(Post $post, PostDto $data): Post
    {
        $post = $post->fill($data->toArray());
        $post->save();
        return $post;
    }
}