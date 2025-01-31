<?php 
namespace Api\Post\Http\Controllers;

use Api\Post\Http\Requests\CreatePostRequest;
use Api\Post\Http\Requests\PostRequest;
use Api\Post\Repository\IPostRepository;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct(protected IPostRepository $repository)
    {
        
    }
    public function postPost(CreatePostRequest $request){
        $post = $this->repository->create($request->toDto());
        if ($request->query("publish") == true) {
            $post = $this->repository->publish($post);
        }
        
        return response()->json($post, 201);
    }
    public function patchPost(PostRequest $request, $id){
        $post = $this->repository->find($id);
        if(!Gate::allows("update-post", $post)){
            abort(403);
        }
        if ($request->query("publish") == true) {
            $post = $this->repository->publish($post);
        }
        $post = $this->repository->patch($post, $request->toDto());
        return response()->json($post);
    }
    public function getPost(PostRequest $request){
        $posts = $this->repository->findAll($request->user());
        return response()->json($posts);
    }
}