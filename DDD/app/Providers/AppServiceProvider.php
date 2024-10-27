<?php

namespace App\Providers;

use App\PostContext\Domain\Post\PostRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
