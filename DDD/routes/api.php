<?php

use App\PostContext\Infrastructure\Comment\Http\CreateCommentController;
use App\PostContext\Infrastructure\Comment\Http\DeleteCommentByIdController;
use App\PostContext\Infrastructure\Comment\Http\GetCommentByIdController;
use App\PostContext\Infrastructure\Comment\Http\GetCommentsController;
use App\PostContext\Infrastructure\Post\Http\DeletePostByIdController;
use App\PostContext\Infrastructure\Post\Http\GetPostByIdController;
use App\PostContext\Infrastructure\Post\Http\GetPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('/', GetPostsController::class);
    Route::get('/{id}', GetPostByIdController::class);
    Route::delete('/{id}', DeletePostByIdController::class);
});

Route::prefix('comments')->group(function () {
    Route::get('/', GetCommentsController::class);
    Route::get('/{id}', GetCommentByIdController::class);
    Route::post('/', CreateCommentController::class);
    Route::delete('/{id}', DeleteCommentByIdController::class);
});

