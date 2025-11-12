<?php

namespace Api\Like\Http\Controllers;

use Api\Like\Http\Requests\PostLikeRequest;
use Api\Like\Model\Like;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
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
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
    public function postLike(PostLikeRequest $request)
    {
        // return response()->json(['message' => 'Needs Authentication'], 401);
        $like = new Like();
        $like->user_id = $request->user()->id;
        if($request->has('comment_id')) {
            $like->comment_id = $request->input('comment_id');
        } else if ($request->has('post_id')) {
            $like->post_id = $request->input('post_id');
        } else {
            return response()->json(['message' => 'Either post_id or comment_id must be provided'], 422);
        }
        try {
            $like->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to add like', 'error' => $th->getMessage()], 400);
        }
        

        return response()->json(['message' => 'Like added successfully', 'like' => $like], 201);
    }
}
