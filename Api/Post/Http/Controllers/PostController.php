<?php 
namespace Api\Post\Http\Controllers;

use Api\Post\Http\Requests\CreatePostRequest;
use Api\Post\Repository\IPostRepository;
use App\Http\Controllers\Controller;


class PostController extends Controller
{
    public function __construct(protected IPostRepository $repository)
    {
        
    }
    public function postPost(CreatePostRequest $request){
        $post = $this->repository->create($request->toDto());
        return response()->json($post, 201);
    }
}