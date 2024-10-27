<?php

use App\PostContext\Infrastructure\Post\Http\DeletePostByIdController;
use App\PostContext\Infrastructure\Post\Http\GetPostByIdController;
use App\PostContext\Infrastructure\Post\Http\GetPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('/', GetPostsController::class);
    Route::get('/{id}', GetPostByIdController::class);
    Route::delete('/{id}', DeletePostByIdController::class);
});