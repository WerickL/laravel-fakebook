<?php

namespace Api\Comment\Http\Controllers;

use Api\Comment\Http\Requests\CommentRequest;
use Api\Comment\Http\Requests\FetchCommentRequest;
use Api\Comment\Http\Requests\PostCommentRequest;
use App\Http\Controllers\Controller;
use Api\Comment\Model\Comment;
use Api\Comment\Repository\CommentRepository;
use Api\Post\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\TryCatch;

class CommentController extends Controller
{
    public function __construct(protected CommentRepository $repository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function postComment(PostCommentRequest $request)
    {

        try {
            $comment = $this->repository->create($request->toDto());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to create comment', 'error' => $th->getMessage()], 400);
        }
        
        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }

    public function patchComment(CommentRequest $request, $id)
    {
        $comment = $this->repository->find($id);
        if(!Gate::allows("updateOrDeleteComment", $comment)){
            abort(403);
        }
        $comment = $this->repository->patch($comment, $request->toDto());
        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }
    public function deleteComment($id)
    {
        $comment = $this->repository->find($id);
        if(!Gate::allows("updateOrDeleteComment", $comment)){
            abort(403);
        }
        $this->repository->delete($comment);
        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
    public function fetchComments(FetchCommentRequest $request, ?int $id = null)
    {
        switch (true) {
            case isset($id):
                $comment = $this->repository->find($id);
                return $comment;
                break;
            case $request->filled('post_id'):
                $comments = $this->repository->fetchCommentsByPostId($request->post_id);
                return $comments;
                break;
            default:
                // all from logged user\
                $comments = $this->repository->fetchComments($request->user());
                return $comments;
                break;
        }
    }
}
