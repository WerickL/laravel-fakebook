<?php

namespace Api\Like\Http\Controllers;

use Api\Like\Http\Requests\PostLikeRequest;
use Api\Like\Model\Like;
use Api\Like\Repository\ILikeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(protected ILikeRepository $repository) {

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
        try {
            $like = $this->repository->create($request->toDto());
            return response()->json(['message' => 'Like added successfully', 'like' => $like], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to add like', 'error' => $th->getMessage()], 400);
        }
        
        
    }
}
