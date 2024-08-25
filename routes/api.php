<?php

use Api\Post\Http\Controllers\PostController;
use Api\User\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get("/user", function (Request $request) {
        return $request->user();
    });
    Route::post("/post", [PostController::class, "postPost"]);
});
Route::post("/user", [UserController::class, "postUser"]);