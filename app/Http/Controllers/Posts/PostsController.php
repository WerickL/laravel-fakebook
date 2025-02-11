<?php

namespace App\Http\Controllers\Posts;

use Api\Post\Model\Post;
use Api\Post\Repository\IPostRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function __construct(protected IPostRepository $repository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = $this->repository->findAll($request->user());
        return Inertia::render("Feed/Index", [
           "posts" => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): HttpResponse
    {
        try {
            $post = $request->user()->posts()->create([
                "description" => $request->description,
                "user_id" => $request->user_id
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        return response("", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
