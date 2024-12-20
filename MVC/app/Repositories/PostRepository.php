<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post\Post;
use App\Models\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    public function getPosts(array $filters = [], int $page = 1, int $limit = 10, string $sort = 'id', string $direction = 'asc', ?string $commentFilter = null, ?string $with = null): array
    {
        $cacheKey = 'posts_' . md5(json_encode($filters) . $page . $limit . $sort . $direction . $commentFilter);

        return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($filters, $page, $limit, $sort, $direction, $commentFilter, $with) {
            $query = Post::query()
                         ->filter($filters)
                         ->withCommentFilter($commentFilter);

            if (!empty($with)) {
                $query->withCount('comments')
                    ->with([$with => function ($query) {
                    $query->limit(10);
                }]);
            }

            $count = $query->count();

            $posts = $query->paginateAndSort($page, $limit, $sort, $direction)
                           ->get();

            return [
                'result' => $posts,
                'count' => $count
            ];
        });
    }

    public function getPostById(int $id): ?Post
    {
        $cacheKey = 'post_' . $id;

        return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($id) {
            return Post::withCount('comments')->with(['comments' => function ($query) {
                $query->paginate(10);
            }])->find($id);
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
