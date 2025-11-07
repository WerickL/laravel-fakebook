<?php

use Api\File\Http\Controllers\FileController;
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
    Route::get("/post/{id?}", [PostController::class, "getPost"]);
    Route::patch("/post/{id}", [PostController::class, "patchPost"]);
    Route::patch("/user/{id}", [UserController::class, "patchUser"]);
    Route::get("/user/follow/{id}", [UserController::class, "followUser"]);
    Route::get("/file/{uuid?}", [FileController::class, "getFile"]);
    Route::post("/file", [FileController::class, "postFile"]);
});
Route::post("/user", [UserController::class, "postUser"]);