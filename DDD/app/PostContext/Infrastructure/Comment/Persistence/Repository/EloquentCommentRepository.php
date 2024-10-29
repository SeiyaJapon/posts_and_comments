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
    public function getComments(array $filters, int $page, int $limit, string $sort, string $direction, ?string $with): array
    {
        $cacheKey = 'comments_' . md5(json_encode($filters) . json_encode($with));

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

    public function getCommentById(CommentId $id, ?string $with = null): ?Comment
    {
        $id = $id->value();
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