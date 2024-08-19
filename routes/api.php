<?php

use Api\Post\Http\Controllers\PostController;
use Api\User\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post("/user", [UserController::class, "postUser"]);
    Route::get("/user", function (Request $request) {
        return "oi";
    });
    Route::post("/post", [PostController::class, "postPost"]);
});