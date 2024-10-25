<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $commentFilter = null): array
    {
        $query = Post::query();

        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        if ($commentFilter) {
            $query->whereHas('comments', function ($q) use ($commentFilter) {
                $q->where('content', 'like', '%' . $commentFilter . '%');
            });
        }

        $count = $query->count();

        $posts = $query->orderBy($sort, $direction)
                       ->skip(($page - 1) * $limit)
                       ->take($limit)
                       ->get();

        return [
            'result' => $posts,
            'count' => $count
        ];
    }

    public function getPostById(int $id): ?Post
    {
        $cacheKey = 'post_' . $id;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id) {
            return Post::with('comments')->find($id);
        });
    }

    public function deletePost(int $id): bool
    {
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

    public function existsById(int $id): bool
    {
        return $this->getPostById($id) !== null;
    }
}
