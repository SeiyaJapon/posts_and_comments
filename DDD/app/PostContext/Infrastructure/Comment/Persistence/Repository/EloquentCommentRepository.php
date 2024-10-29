<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Persistence\Repository;

use App\Models\Comment\Comment;
use App\PostContext\Domain\Comment\CommentId;
use App\PostContext\Domain\Comment\CommentRepositoryInterface;
use App\PostContext\Domain\Comment\Content;
use App\PostContext\Domain\Post\PostId;
use Illuminate\Support\Facades\Cache;

class EloquentCommentRepository implements CommentRepositoryInterface
{
    public function getComments(array $filters, int $page, int $limit, string $sort, string $direction, array $with): array
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

    public function getCommentById(CommentId $id, array $with = []): ?Comment
    {
        $id = $id->value();
        $cacheKey = 'comment_' . $id . '_' . md5(json_encode($with));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($id, $with) {
            $query = Comment::query();

            if (!empty($with)) {
                $query->with($with);
            }

            return $query->find($id);
        });
    }

    public function create(CommentId $id, Content $content, PostId $postId, string $abbreviation): Comment
    {
        try {
            return Comment::create([
                'id' => $id->value(),
                'content' => $content->value(),
                'post_id' => $postId->value(),
                'abbreviation' => $abbreviation
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteById(CommentId $id): bool
    {
        $id = $id->value();
        $comment = Comment::find($id);

        if (!$comment) {
            return false;
        }

        return $comment->delete();
    }

    public function existsByAbbreviation(string $value): bool
    {
        return Comment::where('abbreviation', $value)->exists();
    }
}