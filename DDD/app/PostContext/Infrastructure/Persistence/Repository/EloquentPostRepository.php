<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Persistence\Repository;

use App\Models\Post\Post;
use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $commentFilter = null): array
    {
        $cacheKey = 'posts_' . md5(json_encode($filters) . $page . $limit . $sort . $direction . $commentFilter);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($filters, $page, $limit, $sort, $direction, $commentFilter) {
            $query = Post::query()
                         ->filter($filters)
                         ->withCommentFilter($commentFilter);

            $count = $query->count();

            $posts = $query->paginateAndSort($page, $limit, $sort, $direction)
                           ->get();

            return [
                'result' => $posts,
                'count' => $count
            ];
        });
    }

    public function getPostById(PostId $id): ?Post
    {
        $id = $id->value();
        $cacheKey = 'post_' . $id;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id) {
            return Post::with('comments')->find($id);
        });
    }

    public function deletePost(PostId $id): bool
    {
        // TODO: Implement deletePost() method.
    }

    public function existsById(PostId $id): bool
    {
        // TODO: Implement existsById() method.
    }
}