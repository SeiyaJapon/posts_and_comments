<?php

declare (strict_types=1);

namespace App\Repositories;

use App\Models\Comment\Comment;
use App\Models\Comment\CommentRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CommentRepository implements CommentRepositoryInterface
{
    public function getPaginated(array $filters, int $page, int $limit, string $sort, string $direction, ?string $with= null): array
    {
        $cacheKey = 'comments_' . md5(json_encode($filters) . $with);

        return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($filters, $with, $page, $limit, $sort, $direction) {
            $query = Comment::query()
                            ->filter($filters);

            if (!empty($with)) {
                $query->with([$with => function ($query) {
                    $query->limit(10);
                }]);
            }

            $count = $query->count();

            $comments = $query->orderBy($sort, $direction)
                ->paginate($limit, ['*'], 'page', $page)
                ->items();

            return [
                'result' => $comments,
                'count' => $count
            ];
        });
    }

    public function getCommentById(int $id, ?string $with = null): ?Comment
    {
        $cacheKey = 'comment_' . $id . '_' . md5(json_encode($with));

        return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($id, $with) {
            $query = Comment::query();

            if (!empty($with)) {
                $query->withCount($with)
                    ->with([$with => function ($query) {
                    $query->limit(10);
                }]);
            }

            return $query->find($id);
        });
    }

    public function deleteById(int $id): bool
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

    public function existsByAbbreviation(string $value): bool
    {
        return Comment::where('abbreviation', $value)->exists();
    }
}