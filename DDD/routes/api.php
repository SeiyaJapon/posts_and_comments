<?php

use App\PostContext\Infrastructure\Http\Post\DeletePostByIdController;
use App\PostContext\Infrastructure\Http\Post\GetPostByIdController;
use App\PostContext\Infrastructure\Http\Post\GetPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('/', GetPostsController::class);
    Route::get('/{id}', GetPostByIdController::class);
    Route::delete('/{id}', DeletePostByIdController::class);
});