<?php 
namespace Api\Post\Http\Controllers;

use Api\Post\Http\Requests\CreatePostRequest;
use Api\Post\Repository\IPostRepository;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostController extends Controller
{
    public function __construct(protected IPostRepository $repository)
    {
        
    }
    public function postPost(CreatePostRequest $request){
        $post = $this->repository->create($request->toDto());
        if ($request->query("publish")) {
            $post = $this->repository->publish($post);
        }
        
        return response()->json($post, 201);
    }
}