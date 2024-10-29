<?php

namespace App\Providers;

use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use App\PostContext\Infrastructure\Comment\Persistence\Repository\EloquentCommentRepository;
use App\PostContext\Infrastructure\Comment\Service\ValidateCreateDataService;
use App\PostContext\Infrastructure\Post\Persistence\Repository\EloquentPostRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, EloquentPostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, EloquentCommentRepository::class);
        $this->app->bind(ValidateCreateDataService::class, ValidateCreateDataService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
