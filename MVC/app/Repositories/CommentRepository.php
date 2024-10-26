<?php

declare (strict_types=1);

namespace App\Repositories;

use App\Models\Comment\Comment;
use App\Models\Comment\CommentRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CommentRepository implements CommentRepositoryInterface
{
    public function getPaginated(array $filters, int $page, int $limit, string $sort, string $direction, array $with): array
    {
        $cacheKey = 'comments_' . md5(json_encode($filters) . json_encode($with));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($filters, $with, $page, $limit, $sort, $direction) {
            $query = Comment::query()
                            ->filter($filters)
                            ->orderBy($sort, $direction)
                            ->paginate($limit, ['*'], 'page', $page);

            if (!empty($with)) {
                $query->load($with);
            }

            return [
                'result' => $query->items(),
                'count' => $query->total()
            ];
        });
    }

    public function getCommentById(int $id, array $with = []): ?Comment
    {
        $cacheKey = 'comment_' . $id . '_' . md5(json_encode($with));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id, $with) {
            $query = Comment::query();

            if (!empty($with)) {
                $query->with($with);
            }

            return $query->find($id);
        });
    }

    public function deleteById($id): bool
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return false;
        }

        return $comment->delete();
    }

    public function create(array $data): Comment
    {
        try {
            return Comment::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}