<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Post\Persistence\Repository;

use App\Models\Post\Post;
use App\PostContext\Domain\Post\PostId;
use App\PostContext\Domain\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $commentFilter = null): array
    {
        $cacheKey = 'posts_' . md5(json_encode($filters) . $page . $limit . $sort . $direction . $commentFilter);

        return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($filters, $page, $limit, $sort, $direction, $commentFilter) {
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

        return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($id) {
            return Post::with('comments')->find($id);
        });
    }

    public function deletePost(PostId $id): bool
    {
        $id = $id->value();
        $post = Post::find($id);

        if ($post) {
            $post->comments()->delete();
            $deleted = $post->delete();

            Cache::forget('post_' . $id);
            Cache::forget('posts');

            return $deleted;
        }

        return false;
    }

    public function existsById(PostId $id): bool
    {
        return $this->getPostById($id) !== null;
    }
}